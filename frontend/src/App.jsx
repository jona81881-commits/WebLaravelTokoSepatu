import { Routes, Route } from "react-router-dom";
import AdminDashboard from "./pages/adminpages/AdminDashboard";
import AdminLayout from "./layouts/AdminLayout";
import AboutPage from "./pages/adminpages/AboutPage";
import MainLayout from "./layouts/MainLayout";
import Dashboard from "./pages/frontpages/Dashboard";
import ProductDetail from "./pages/frontpages/ProductDetail";
import Cart from "./pages/frontpages/Cart";
import Checkout from "./pages/frontpages/Checkout";
import Login from "./pages/frontpages/Login";
import ProductForm from "./pages/adminpages/ProductForm";
import ProductEdit from "./pages/adminpages/ProductEdit";
import AdminRoute from "./components/AdminRoute";

export default function App() {
  return (
    <Routes>
      <Route path="/" element={<MainLayout />}>
        <Route index element={<Dashboard />} />
        <Route path="product/:id" element={<ProductDetail />} />
        <Route path="cart" element={<Cart />} />
        <Route path="checkout" element={<Checkout />} />
        <Route path="login" element={<Login />} />
      </Route>

      {/* Halaman admin: wajib login sebagai admin */}
      <Route element={<AdminRoute />}>
        <Route path="/admin" element={<AdminLayout />}>
          <Route path="dashboard" element={<AdminDashboard />} />
          <Route path="about" element={<AboutPage />} />
          <Route path="add-product" element={<ProductForm />} />
          <Route path="edit-product/:id" element={<ProductEdit />} />
        </Route>
      </Route>
    </Routes>
  );
}