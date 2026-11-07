import { useState } from "react";
import { Link } from "react-router-dom";
import toast from "react-hot-toast";
// PERUBAHAN 1: tambah keepPreviousData
import { useQuery, keepPreviousData } from "@tanstack/react-query";
import { useProducts } from "../../utils/ProductContext";
import ProductSearchBar from "../../components/ProductSearchBar";
import Pagination from "../../components/Pagination";

const LIMIT = 6;

export default function AdminDashboard() {
  const { getProducts, deleteProduct } = useProducts();

  const [filter, setFilter] = useState({ keyword: "", category: "" });
  const [page, setPage] = useState(1);

  // data produk diambil dari API sesuai halaman dan filter
  const { data, isLoading, isError } = useQuery({
    queryKey: ["products", page, filter],
    // PERUBAHAN 2: tampilkan data lama selagi data baru dimuat
    placeholderData: keepPreviousData,
    queryFn: () =>
      getProducts({
        page,
        limit: LIMIT,
        category_id: filter.category,
        keyword: filter.keyword,
      }),
  });

  const products = data?.data ?? [];
  const lastPage = data?.meta?.last_page ?? 1;

  const handleSearch = ({ keyword, category }) => {
    setFilter({ keyword, category });
    setPage(1);
  };

  const handleDelete = async (id) => {
    if (!window.confirm("Apakah kamu yakin ingin menghapus produk ini?")) return;
    try {
      await deleteProduct.mutateAsync(id);
      toast.success("Produk berhasil dihapus!");
    } catch (error) {
      toast.error(
        error.response?.data?.message || "Terjadi kesalahan saat menghapus produk."
      );
    }
  };

  if (isLoading) return <p>Loading...</p>;
  if (isError) return <p>Error loading products.</p>;

  return (
    <div className="p-4">
      <div className="flex items-center justify-between bg-white p-3 rounded shadow mb-4">
        <ProductSearchBar onSearch={handleSearch} />
        <Link
          to="/admin/add-product"
          className="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded"
        >
          + Tambah Produk
        </Link>
      </div>

      <table className="table-auto w-full border bg-white">
        <thead>
          <tr className="bg-gray-100 text-left">
            <th className="p-2 border">#</th>
            <th className="p-2 border">Image</th>
            <th className="p-2 border">Nama</th>
            <th className="p-2 border">Harga</th>
            <th className="p-2 border">Stok</th>
            <th className="p-2 border">Aksi</th>
          </tr>
        </thead>
        <tbody>
          {products.length === 0 && (
            <tr>
              <td colSpan="6" className="p-4 text-center text-gray-500">
                Produk tidak ditemukan.
              </td>
            </tr>
          )}
          {products.map((p, index) => (
            <tr key={p.id}>
              <td className="p-2 border">{(page - 1) * LIMIT + index + 1}</td>
              <td className="p-2 border">
                <img src={p.img_url} alt={p.name} className="w-16 h-16 object-cover" />
              </td>
              <td className="p-2 border">
                {p.name} <br />
                <small className="text-gray-500">#{p.category?.name}</small>
              </td>
              <td className="p-2 border">Rp. {p.price}</td>
              <td className="p-2 border">{p.stock}</td>
              <td className="p-2 border space-x-2">
                <Link to={`/admin/edit-product/${p.id}`} className="text-blue-600 hover:underline">
                  Edit
                </Link>
                <button
                  onClick={() => handleDelete(p.id)}
                  className="cursor-pointer text-red-600 hover:underline"
                >
                  Hapus
                </button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>

      <Pagination page={page} lastPage={lastPage} onPageChange={setPage} />
    </div>
  );
}