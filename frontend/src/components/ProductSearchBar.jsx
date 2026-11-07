import { useState } from "react";
import { useQuery } from "@tanstack/react-query";
import { useProducts } from "../utils/ProductContext";

export default function ProductSearchBar({ onSearch }) {
  const { getCategories } = useProducts();
  const [keyword, setKeyword] = useState("");
  const [category, setCategory] = useState("");

  const { data: categories = [] } = useQuery({
    queryKey: ["categories"],
    queryFn: getCategories,
  });

  const handleSubmit = (e) => {
    e.preventDefault();
    onSearch({ keyword, category });
  };

  return (
    <form onSubmit={handleSubmit} className="flex items-center gap-2">
      <select
        value={category}
        onChange={(e) => setCategory(e.target.value)}
        className="border rounded-md p-2 text-sm"
      >
        <option value="">Semua Kategori</option>
        {categories.map((cat) => (
          <option key={cat.category_id} value={cat.category_id}>
            {cat.category}
          </option>
        ))}
      </select>

      <input
        value={keyword}
        onChange={(e) => setKeyword(e.target.value)}
        placeholder="Cari produk..."
        className="border rounded-md p-2 text-sm"
      />

      <button
        type="submit"
        className="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-md"
      >
        Cari
      </button>
    </form>
  );
}
