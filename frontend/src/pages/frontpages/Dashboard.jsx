import { useState } from "react";
import { Link } from "react-router-dom";
import { useQuery } from "@tanstack/react-query";
import { useProducts } from "../../utils/ProductContext";
import Pagination from "../../components/Pagination";

const LIMIT = 8;
const HERO_IMG = "http://127.0.0.1:8000/assets/images/hero-banner.jpg";
const rupiah = (n) => "Rp " + new Intl.NumberFormat("id-ID").format(n);

export default function Dashboard() {
  const { getProducts, getCategories } = useProducts();

  const [keywordInput, setKeywordInput] = useState("");
  const [keyword, setKeyword] = useState("");
  const [category, setCategory] = useState("");
  const [page, setPage] = useState(1);

  const { data: categories = [] } = useQuery({
    queryKey: ["categories"],
    queryFn: getCategories,
  });

  const { data, isLoading, isError } = useQuery({
    queryKey: ["products", "home", page, category, keyword],
    queryFn: () =>
      getProducts({ page, limit: LIMIT, category_id: category, keyword }),
  });

  const products = data?.data ?? [];
  const lastPage = data?.meta?.last_page ?? 1;
  const total = data?.meta?.total ?? 0;
  const activeCategory = categories.find(
    (c) => String(c.category_id) === String(category)
  );

  const handleSearch = (e) => {
    e.preventDefault();
    setKeyword(keywordInput);
    setPage(1);
  };

  return (
    <div>
      {/* Filter */}
      <form
        onSubmit={handleSearch}
        className="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-brand-mist/55 border border-brand-sky/45 rounded-2xl p-4 mb-8"
      >
        <input
          value={keywordInput}
          onChange={(e) => setKeywordInput(e.target.value)}
          placeholder="Cari sepatu kets, lari, formal, bot..."
          className="w-full md:w-1/2 px-4 py-3 rounded-xl bg-white text-sm border border-brand-sky/70 outline-none focus:ring-2 focus:ring-brand-blue/40"
        />
        <div className="flex items-center gap-3">
          <select
            value={category}
            onChange={(e) => {
              setCategory(e.target.value);
              setPage(1);
            }}
            className="px-4 py-3 rounded-xl bg-white text-sm font-semibold border border-brand-sky/70 outline-none"
          >
            <option value="">Semua Kategori</option>
            {categories.map((c) => (
              <option key={c.category_id} value={c.category_id}>
                {c.category}
              </option>
            ))}
          </select>
          <button
            type="submit"
            className="px-5 py-3 rounded-xl bg-brand-blue hover:bg-brand-navy text-white text-sm font-semibold transition cursor-pointer"
          >
            Cari
          </button>
        </div>
      </form>

      {/* Hero */}
      <section
        className="rounded-3xl text-white mb-10 min-h-[200px] flex flex-col justify-center px-6 md:px-10 py-7 bg-cover bg-center shadow-xl"
        style={{
          backgroundImage: `linear-gradient(100deg, rgba(40,53,131,.96) 0%, rgba(40,53,131,.82) 45%, rgba(68,118,219,.55) 100%), url('${HERO_IMG}')`,
        }}
      >
        <span className="w-fit text-xs font-semibold bg-white/10 border border-white/25 px-3.5 py-1.5 rounded-full mb-3">
          ✦ Koleksi Sepatu 2026
        </span>
        <h1 className="text-2xl md:text-4xl font-extrabold tracking-tight max-w-3xl">
          Langkah Terbaikmu Dimulai di Sini.
        </h1>
        <p className="mt-2 text-white/85 text-sm md:text-base max-w-xl">
          Koleksi sepatu kets, lari, formal, kasual, dan bot dengan harga
          bersahabat.
        </p>
      </section>

      {/* Katalog */}
      <div className="mb-6 pb-4 border-b border-brand-sky/50">
        <h2 className="text-3xl font-extrabold tracking-tight">Katalog Produk</h2>
        <p className="mt-1 text-sm text-slate-500">
          Kategori:{" "}
          <span className="font-bold text-brand-blue">
            {activeCategory?.category ?? "Semua Kategori"}
          </span>{" "}
          • Menampilkan{" "}
          <span className="font-bold text-brand-blue">{total}</span> produk
        </p>
      </div>

      {isLoading && <p>Memuat produk...</p>}
      {isError && (
        <p className="text-red-500">
          Gagal memuat produk. Pastikan backend (php artisan serve) berjalan.
        </p>
      )}
      {!isLoading && !isError && products.length === 0 && (
        <p className="text-gray-500">Sepatu yang kamu cari tidak ditemukan.</p>
      )}

      <div className="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        {products.map((p) => {
          const soldOut = p.stock <= 0;
          const lowStock = p.stock > 0 && p.stock <= 8;
          return (
            <div
              key={p.id}
              className="group bg-white rounded-[20px] overflow-hidden flex flex-col border border-brand-sky/40 shadow-md hover:shadow-xl hover:-translate-y-1 transition"
            >
              <Link
                to={`/product/${p.id}`}
                className="relative block aspect-[4/3] bg-gradient-to-br from-brand-mist/70 to-white p-6 overflow-hidden"
              >
                <img
                  src={p.img_url}
                  alt={p.name}
                  className="w-full h-full object-contain mix-blend-multiply transition-transform duration-500 group-hover:scale-110"
                />
                <span className="absolute top-4 left-4 text-[11px] font-bold tracking-wider uppercase bg-brand-navy text-white px-3.5 py-1.5 rounded-full">
                  {p.category?.name ?? "-"}
                </span>
                {soldOut && (
                  <span className="absolute top-4 right-4 bg-red-500 text-white text-[11px] font-bold px-3 py-1.5 rounded-full">
                    Stok Habis
                  </span>
                )}
                {lowStock && (
                  <span className="absolute top-4 right-4 bg-amber-400 text-white text-[11px] font-bold px-3 py-1.5 rounded-full">
                    Stok Tinggal {p.stock}
                  </span>
                )}
              </Link>

              <div className="p-5 flex flex-col flex-1">
                <h3 className="font-bold text-lg leading-snug">{p.name}</h3>
                <p className="text-brand-blue font-extrabold text-xl mt-2">
                  {rupiah(p.price)}
                </p>
                <div className="mt-auto pt-4 flex gap-2">
                  <Link
                    to={`/product/${p.id}`}
                    className="px-4 py-2.5 rounded-xl border border-brand-sky text-sm font-semibold hover:bg-brand-mist transition"
                  >
                    Detail
                  </Link>
                  {soldOut ? (
                    <span className="flex-1 text-center px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-gray-300">
                      Tidak Tersedia
                    </span>
                  ) : (
                    <Link
                      to={`/product/${p.id}`}
                      className="flex-1 text-center px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-brand-blue hover:bg-brand-navy transition"
                    >
                      Beli Sekarang
                    </Link>
                  )}
                </div>
              </div>
            </div>
          );
        })}
      </div>

      <Pagination page={page} lastPage={lastPage} onPageChange={setPage} />
    </div>
  );
}