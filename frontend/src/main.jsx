import React from "react";
import ReactDOM from "react-dom/client";
import { BrowserRouter } from "react-router-dom";
import App from "./App";
import "./index.css";
import { CartProvider } from "./utils/CartContext";
import { ProductProvider } from "./utils/ProductContext";
import { AuthProvider } from "./utils/AuthContext";
import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { Toaster } from "react-hot-toast";

const queryClient = new QueryClient();

ReactDOM.createRoot(document.getElementById("root")).render(
  <React.StrictMode>
    <BrowserRouter>
      <QueryClientProvider client={queryClient}>
        <AuthProvider>
          <ProductProvider>
            <CartProvider>
              <App />
              <Toaster position="top-right" reverseOrder={false} />
            </CartProvider>
          </ProductProvider>
        </AuthProvider>
      </QueryClientProvider>
    </BrowserRouter>
  </React.StrictMode>
);