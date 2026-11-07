import { Outlet, NavLink, Link } from "react-router-dom";
import { useCart } from "../utils/CartContext";
import { useAuth } from "../utils/AuthContext";

export default function MainLayout() {
  // Hook HARUS dipanggil di dalam komponen, bukan di level modul
  const { totalItems } = useCart();
  const { isAdmin } = useAuth();

  const linkClass = ({ isActive }) =>
    "px-4 py-2.5 rounded-xl font-semibold text-[15px] text-white transition " +
    (isActive ? "bg-white/15" : "hover:bg-white/10");

  return (
    <div className="min-h-screen flex flex-col">
      <header className="sticky top-0 z-50 bg-brand-navy text-white shadow-lg">
        <div className="max-w-[1520px] mx-auto px-5 md:px-10 py-3.5 flex items-center justify-between">
          <Link to="/" className="flex items-center gap-3 text-white">
            <div className="flex items-center justify-center w-12 h-12 text-2xl rounded-2xl bg-gradient-to-br from-brand-sky to-brand-blue shadow-md">
              👟
            </div>
            <div>
              <div className="text-[22px] font-extrabold leading-none tracking-wide">
                Josepa
              </div>
              <div className="text-[11px] font-bold tracking-[0.14em] text-brand-sky mt-1">
                TOKO SEPATU
              </div>
            </div>
          </Link>

          <nav className="flex items-center gap-1">
            <NavLink to="/cart" className={linkClass}>
              Keranjang
              {totalItems > 0 && (
                <span className="ml-2 inline-flex items-center justify-center min-w-5 h-5 px-1.5 text-[11px] font-bold rounded-full bg-brand-sky text-brand-navy">
                  {totalItems}
                </span>
              )}
            </NavLink>
            <Link
              to={isAdmin ? "/admin/dashboard" : "/login"}
              className="ml-2 px-4 py-2.5 rounded-xl font-semibold text-[15px] bg-white/10 border border-white/30 hover:bg-white/20 transition"
            >
              {isAdmin ? "Admin" : "Login"}
            </Link>
          </nav>
        </div>
      </header>

      <main className="flex-1 w-full max-w-[1520px] mx-auto px-5 md:px-10 py-8">
        <Outlet />
      </main>

      <footer className="py-7 bg-brand-navy text-brand-mist text-center text-sm">
        © 2026 Josepa | Jonathan Valerio Simatupang | Versi 1.0
      </footer>
    </div>
  );
}