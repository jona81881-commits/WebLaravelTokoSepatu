import { useState } from "react";
import { Link } from "react-router-dom";
import toast from "react-hot-toast";
import { useCart } from "../../utils/CartContext";
import { useProducts } from "../../utils/ProductContext";
import { rupiah } from "../../utils/format";

export default function Checkout() {
  const { cart, removeFromCart, totalPrice } = useCart();
  const { createOrder } = useProducts();

  const [form, setForm] = useState({ customer_name: "", phone: "", address: "" });
  const [errors, setErrors] = useState({});
  const [loading, setLoading] = useState(false);
  const [codes, setCodes] = useState([]); // kode pesanan yang berhasil

  const handleChange = (e) => setForm({ ...form, [e.target.name]: e.target.value });

  const handleSubmit = async (e) => {
    e.preventDefault();
    setErrors({});
    setLoading(true);
    const done = [];

    try {
      // backend menerima 1 produk per pesanan, jadi dikirim satu per satu
      for (const item of [...cart]) {
        const order = await createOrder({
          product_id: item.id,
          quantity: item.qty,
          ...form,
        });
        done.push(order.order_code);
        removeFromCart(item.id);
      }
      setCodes(done);
      toast.success("Pesanan berhasil dibuat!");
    } catch (error) {
      if (done.length) setCodes(done);
      if (error.response?.status === 422) {
        const errs = error.response.data.errors || {};
        setErrors(errs);
        toast.error(Object.values(errs)[0]?.[0] || "⚠ Periksa kembali data.");
      } else {
        toast.error("❌ Gagal membuat pesanan. Pastikan backend berjalan.");
      }
    } finally {
      setLoading(false);
    }
  };

  // Tampilan sukses
  if (codes.length > 0 && cart.length === 0)
    return (
      <div className="max-w-lg mx-auto text-center bg-white rounded-3xl border border-brand-sky/40 shadow-md p-10">
        <div className="text-5xl">✅</div>
        <h1 className="text-2xl font-extrabold mt-3">Pesanan Berhasil!</h1>
        <p className="text-slate-500 mt-2">Simpan kode pesanan kamu:</p>
        <div className="mt-3 space-y-1">
          {codes.map((c) => (
            <p key={c} className="font-mono font-bold text-brand-blue text-lg">
              {c}
            </p>
          ))}
        </div>
        <Link
          to="/"
          className="inline-block mt-6 px-6 py-3 rounded-xl bg-brand-blue hover:bg-brand-navy text-white font-semibold transition"
        >
          Kembali ke Beranda
        </Link>
      </div>
    );

  if (cart.length === 0)
    return (
      <div className="text-center py-16">
        <h1 className="text-2xl font-extrabold">Keranjang kosong</h1>
        <Link to="/" className="text-brand-blue font-semibold hover:underline">
          Pilih sepatu dulu →
        </Link>
      </div>
    );

  const field = (name) =>
    `border rounded-md p-2 w-full ${errors[name] ? "border-red-500" : "border-gray-300"}`;

  return (
    <div>
      <h1 className="text-3xl font-extrabold mb-6">Checkout</h1>

      <div className="grid lg:grid-cols-3 gap-6">
        <form
          onSubmit={handleSubmit}
          className="lg:col-span-2 bg-white rounded-2xl border border-brand-sky/40 shadow-sm p-6 space-y-4"
        >
          <h2 className="font-extrabold text-lg border-b pb-2">Data Penerima</h2>

          <div className="flex flex-col">
            <label className="text-sm font-medium text-gray-600 mb-1">Nama Penerima</label>
            <input name="customer_name" value={form.customer_name} onChange={handleChange} className={field("customer_name")} />
            {errors.customer_name && <p className="text-red-500 text-sm mt-1">{errors.customer_name[0]}</p>}
          </div>

          <div className="flex flex-col">
            <label className="text-sm font-medium text-gray-600 mb-1">No. Telepon</label>
            <input name="phone" value={form.phone} onChange={handleChange} placeholder="08123456789" className={field("phone")} />
            {errors.phone && <p className="text-red-500 text-sm mt-1">{errors.phone[0]}</p>}
          </div>

          <div className="flex flex-col">
            <label className="text-sm font-medium text-gray-600 mb-1">Alamat Lengkap</label>
            <textarea name="address" rows="3" value={form.address} onChange={handleChange} className={field("address")} />
            {errors.address && <p className="text-red-500 text-sm mt-1">{errors.address[0]}</p>}
          </div>

          {errors.quantity && (
            <p className="text-red-500 text-sm">{errors.quantity[0]}</p>
          )}

          <button
            type="submit"
            disabled={loading}
            className="w-full py-3 rounded-xl bg-brand-blue hover:bg-brand-navy disabled:bg-gray-300 text-white font-semibold transition cursor-pointer"
          >
            {loading ? "Memproses..." : "Buat Pesanan"}
          </button>
        </form>

        <aside className="bg-white rounded-2xl border border-brand-sky/40 shadow-sm p-6 h-fit">
          <h2 className="font-extrabold text-lg mb-4">Pesanan Kamu</h2>
          {cart.map((i) => (
            <div key={i.id} className="flex justify-between text-sm mb-2">
              <span>
                {i.name} × {i.qty}
              </span>
              <span>{rupiah(i.price * i.qty)}</span>
            </div>
          ))}
          <div className="flex justify-between font-extrabold text-lg border-t pt-3 mt-3">
            <span>Total</span>
            <span className="text-brand-blue">{rupiah(totalPrice)}</span>
          </div>
        </aside>
      </div>
    </div>
  );
}