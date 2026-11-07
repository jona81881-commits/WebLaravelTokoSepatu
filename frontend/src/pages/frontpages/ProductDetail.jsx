import { useState } from "react";
import { Link, useNavigate, useParams } from "react-router-dom";
import { useQuery } from "@tanstack/react-query";
import toast from "react-hot-toast";
import { useProducts } from "../../utils/ProductContext";
import { useCart } from "../../utils/CartContext";
import { rupiah } from "../../utils/format";

export default function ProductDetail() {
  const { id } = useParams();
  const navigate = useNavigate();
  const { getProductById } = useProducts();
  const { addToCart } = useCart();
  const [qty, setQty] = useState(1);

  const { data: product, isLoading, isError } = useQuery({
    queryKey: ["product", id],
    queryFn: () => getProductById(id),
  });

  if (isLoading) return <p>Memuat produk...</p>;
  if (isError || !product)
    return (
      <div>
        <p className="text-red-500 mb-4">Produk tidak ditemukan.</p>
        <Link to="/" className="text-brand-blue font-semibold hover:underline">
          ← Kembali ke katalog
        </Link>
      </div>
    );

  const soldOut = product.stock <= 0;

  const changeQty = (value) => {
    const n = Number(value) || 1;
    setQty(Math.max(1, Math.min(n, product.stock)));
  };

  const handleAdd = () => {
    addToCart(product, qty);
    toast.success(`${product.name} ditambahkan ke keranjang`);
  };

  const handleBuyNow = () => {
    addToCart(product, qty);
    navigate("/cart");
  };

  return (
    <div>
      <Link to="/" className="text-sm font-semibold text-brand-blue hover:underline">
        ← Kembali ke katalog
      </Link>

      <div className="mt-4 grid md:grid-cols-2 gap-8 bg-white rounded-3xl border border-brand-sky/40 shadow-md p-6 md:p-10">
        <div className="bg-gradient-to-br from-brand-mist/70 to-white rounded-2xl p-8 flex items-center justify-center">
          {product.img_url && (
            <img
              src={product.img_url}
              alt={product.name}
              className="w-full max-h-[420px] object-contain mix-blend-multiply"
            />
          )}
        </div>

        <div className="flex flex-col">
          <span className="w-fit text-[11px] font-bold tracking-wider uppercase bg-brand-navy text-white px-3.5 py-1.5 rounded-full">
            {product.category?.name ?? "-"}
          </span>
          <h1 className="text-3xl font-extrabold mt-3">{product.name}</h1>
          <p className="text-brand-blue font-extrabold text-3xl mt-2">
            {rupiah(product.price)}
          </p>
          <p className="mt-4 text-slate-600 leading-relaxed">
            {product.description || "Belum ada deskripsi untuk produk ini."}
          </p>
          <p className="mt-4 text-sm">
            Stok:{" "}
            <span className={`font-bold ${soldOut ? "text-red-500" : "text-brand-blue"}`}>
              {soldOut ? "Habis" : product.stock}
            </span>
          </p>

          {!soldOut && (
            <>
              <div className="mt-5 flex items-center gap-3">
                <span className="text-sm font-semibold">Jumlah:</span>
                <div className="flex items-center border border-brand-sky rounded-xl overflow-hidden">
                  <button
                    onClick={() => changeQty(qty - 1)}
                    className="px-4 py-2 hover:bg-brand-mist cursor-pointer"
                  >
                    −
                  </button>
                  <input
                    value={qty}
                    onChange={(e) => changeQty(e.target.value)}
                    className="w-14 text-center py-2 outline-none"
                  />
                  <button
                    onClick={() => changeQty(qty + 1)}
                    className="px-4 py-2 hover:bg-brand-mist cursor-pointer"
                  >
                    +
                  </button>
                </div>
              </div>

              <div className="mt-6 flex gap-3">
                <button
                  onClick={handleAdd}
                  className="px-5 py-3 rounded-xl border border-brand-sky font-semibold hover:bg-brand-mist transition cursor-pointer"
                >
                  + Keranjang
                </button>
                <button
                  onClick={handleBuyNow}
                  className="flex-1 px-5 py-3 rounded-xl bg-brand-blue hover:bg-brand-navy text-white font-semibold transition cursor-pointer"
                >
                  Beli Sekarang
                </button>
              </div>
            </>
          )}
        </div>
      </div>
    </div>
  );
}