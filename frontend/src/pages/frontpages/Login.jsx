import { useState } from "react";
import { Navigate, useLocation, useNavigate } from "react-router-dom";
import toast from "react-hot-toast";
import { useAuth } from "../../utils/AuthContext";

export default function Login() {
  const { login, isAdmin } = useAuth();
  const navigate = useNavigate();
  const location = useLocation();

  const [form, setForm] = useState({ email: "", password: "" });
  const [errors, setErrors] = useState({});
  const [loading, setLoading] = useState(false);

  // halaman tujuan setelah login (default: dashboard admin)
  const from = location.state?.from || "/admin/dashboard";

  // kalau sudah login sebagai admin, langsung ke dashboard
  if (isAdmin) return <Navigate to={from} replace />;

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setErrors({});
    setLoading(true);

    try {
      const data = await login(form.email, form.password);

      if (data.user?.is_admin) {
        toast.success("Login berhasil!");
        navigate(from, { replace: true });
      } else {
        toast.error("Akun ini bukan admin.");
        navigate("/", { replace: true });
      }
    } catch (error) {
      if (error.response?.status === 422) {
        setErrors(error.response.data.errors || {});
        toast.error("⚠ Periksa kembali data yang dimasukkan.");
      } else if (error.response?.status === 401) {
        toast.error(error.response.data.message || "Email atau password salah.");
      } else {
        toast.error("❌ Gagal login. Pastikan backend berjalan.");
      }
    } finally {
      setLoading(false);
    }
  };

  return (
    <form
      onSubmit={handleSubmit}
      className="max-w-md mx-auto mt-10 bg-white shadow-md rounded-2xl p-6 space-y-4"
    >
      <h2 className="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">
        Login Admin
      </h2>

      <div className="flex flex-col">
        <label className="text-sm font-medium text-gray-600 mb-1">Email</label>
        <input
          name="email"
          type="email"
          placeholder="admin@josepa.test"
          value={form.email}
          onChange={handleChange}
          className={`border rounded-md p-2 w-full ${errors.email ? "border-red-500" : ""}`}
        />
        {errors.email && <p className="text-red-500 text-sm mt-1">{errors.email[0]}</p>}
      </div>

      <div className="flex flex-col">
        <label className="text-sm font-medium text-gray-600 mb-1">Password</label>
        <input
          name="password"
          type="password"
          placeholder="Password"
          value={form.password}
          onChange={handleChange}
          className={`border rounded-md p-2 w-full ${errors.password ? "border-red-500" : ""}`}
        />
        {errors.password && (
          <p className="text-red-500 text-sm mt-1">{errors.password[0]}</p>
        )}
      </div>

      <button
        type="submit"
        disabled={loading}
        className="w-full cursor-pointer bg-blue-600 hover:bg-blue-700 disabled:bg-gray-300 text-white font-semibold py-2 rounded-lg transition duration-200"
      >
        {loading ? "Memproses..." : "Masuk"}
      </button>
    </form>
  );
}