import { Navigate, Outlet, useLocation } from "react-router-dom";
import { useAuth } from "../utils/AuthContext";

// Pembungkus route admin: kalau belum login sebagai admin -> ke /login
export default function AdminRoute() {
  const { isAdmin } = useAuth();
  const location = useLocation();

  if (!isAdmin) {
    return <Navigate to="/login" replace state={{ from: location.pathname }} />;
  }

  return <Outlet />;
}