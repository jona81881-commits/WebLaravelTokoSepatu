import { Link } from "react-router-dom";
import { useCart } from "../../utils/CartContext";
import { rupiah } from "../../utils/format";

export default function Cart() {
  const { cart, updateQty, removeFromCart, clearCart, totalItems, totalPrice } =
    useCart();

  if (cart.length === 0)
    return (
      <div className="text-center py-16">
        <h1 className="text-3xl font-extrabold">Keranjang Kosong</h1>
        <p className="text-slate-500 mt-2">Belum ada sepatu di keranjangmu.</p>
        <Link
          to="/"
          className="inline-block mt-6 px-6 py-3 rounded-xl bg-brand-blue hover:bg-brand-navy text-white font-semibold transition"
        >
          Lihat Katalog
        </Link>
      </div>
    );

  return (
    <div>
      <div className="flex items-center justify-between mb-6">
        <h1 className="text-3xl font-extrabold">Keranjang Belanja</h1>
        <button
          onClick={() => window.confirm("Kosongkan keranjang?") && clearCart()}
          className="text-sm text-red-600 hover:underline cursor-pointer"
        >
          Kosongkan
        </button>
      </div>

      <div className="grid lg:grid-cols-3 gap-6">
        <div className="lg:col-span-2 space-y-4">
          {cart.map((item) => (
            <div
              key={item.id}
              className="flex items-center gap-4 bg-white rounded-2xl border border-brand-sky/40 shadow-sm p-4"
            >
              <div className="w-24 h-24 shrink-0 rounded-xl bg-brand-mist/60 flex items-center justify-center p-2">
                {item.img_url && (
                  <img
                    src={item.img_url}
                    alt={item.name}
                    className="w-full h-full object-contain mix-blend-multiply"
                  />
                )}
              </div>

              <div className="flex-1">
                <Link to={`/product/${item.id}`} className="font-bold hover:underline">
                  {item.name}
                </Link>
                <p className="text-xs text-slate-500">{item.category}</p>
                <p className="text-brand-blue font-bold mt-1">{rupiah(item.price)}</p>

                <div className="mt-2 flex items-center gap-3">
                  <div className="flex items-center border border-brand-sky rounded-lg overflow-hidden text-sm">
                    <button
                      onClick={() => updateQty(item.id, item.qty - 1)}
                      className="px-3 py-1 hover:bg-brand-mist cursor-pointer"
                    >
                      −
                    </button>
                    <span className="px-3">{item.qty}</span>
                    <button
                      onClick={() => updateQty(item.id, item.qty + 1)}
                      className="px-3 py-1 hover:bg-brand-mist cursor-pointer"
                    >
                      +
                    </button>
                  </div>
                  <button
                    onClick={() => removeFromCart(item.id)}
                    className="text-sm text-red-600 hover:underline cursor-pointer"
                  >
                    Hapus
                  </button>
                </div>
              </div>

              <div className="font-extrabold">{rupiah(item.price * item.qty)}</div>
            </div>
          ))}
        </div>

        <aside className="bg-white rounded-2xl border border-brand-sky/40 shadow-sm p-6 h-fit">
          <h2 className="font-extrabold text-lg mb-4">Ringkasan</h2>
          <div className="flex justify-between text-sm mb-2">
            <span>Jumlah barang</span>
            <span>{totalItems}</span>
          </div>
          <div className="flex justify-between font-extrabold text-lg border-t pt-3">
            <span>Total</span>
            <span className="text-brand-blue">{rupiah(totalPrice)}</span>
          </div>
          <Link
            to="/checkout"
            className="block text-center mt-5 px-5 py-3 rounded-xl bg-brand-blue hover:bg-brand-navy text-white font-semibold transition"
          >
            Lanjut ke Checkout
          </Link>
        </aside>
      </div>
    </div>
  );
}