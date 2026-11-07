export default function Pagination({ page, lastPage, onPageChange }) {
  const pages = Array.from({ length: lastPage }, (_, i) => i + 1);

  return (
    <div className="flex items-center justify-center gap-2 mt-4">
      <button
        disabled={page <= 1}
        onClick={() => onPageChange(page - 1)}
        className="px-3 py-1 text-sm rounded bg-blue-500 text-white disabled:bg-gray-200 disabled:text-gray-400"
      >
        Sebelumnya
      </button>

      {pages.map((n) => (
        <button
          key={n}
          onClick={() => onPageChange(n)}
          className={`px-3 py-1 text-sm rounded ${
            n === page ? "bg-blue-600 text-white" : "bg-gray-100 text-gray-700"
          }`}
        >
          {n}
        </button>
      ))}

      <button
        disabled={page >= lastPage}
        onClick={() => onPageChange(page + 1)}
        className="px-3 py-1 text-sm rounded bg-blue-500 text-white disabled:bg-gray-200 disabled:text-gray-400"
      >
        Berikutnya
      </button>
    </div>
  );
}
