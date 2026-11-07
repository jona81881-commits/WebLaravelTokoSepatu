import { Outlet, Link, useNavigate } from "react-router-dom";
import toast from "react-hot-toast";
import { useAuth } from "../utils/AuthContext";

export default function AdminLayout() {
  const { logout, user } = useAuth();
  const navigate = useNavigate();

  const handleLogout = async () => {
    await logout();
    toast.success("Berhasil logout.");
    navigate("/login", { replace: true });
  };

  return (
    <div className="flex min-h-screen bg-gray-100">
      <aside className="w-48 bg-white p-4 shadow space-y-2">
        <h2 className="font-bold mb-1">My Admin</h2>
        <p className="text-xs text-gray-500 mb-4">{user?.name}</p>
        <Link to="/admin/dashboard" className="block text-sm">Dashboard</Link>
        <Link to="/admin/about" className="block text-sm">About</Link>
        <Link to="/" className="block text-sm">Lihat Toko</Link>
        <button
          onClick={handleLogout}
          className="block text-sm text-red-600 cursor-pointer hover:underline"
        >
          Logout
        </button>
      </aside>
      <main className="flex-1 p-6">
        <Outlet />
      </main>
    </div>
  );
}