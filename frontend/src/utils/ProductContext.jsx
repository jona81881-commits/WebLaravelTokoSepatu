import React, { createContext, useContext } from "react";
import { useQuery, useMutation, useQueryClient } from "@tanstack/react-query";
import apiClient from "./apiClient";

// Buat konteks
const ProductContext = createContext();

export const ProductProvider = ({ children }) => {
  const queryClient = useQueryClient();

  // GET ALL PRODUCTS
  const { data: products, isLoading, isError } = useQuery({
    queryKey: ["products"],
    queryFn: async () => {
      const res = await apiClient.get("/products");
      return res.data.data;
    },
  });

  // SHOW PRODUCT DETAIL
  const getProductById = async (id) => {
    const res = await apiClient.get(`/products/${id}`);
    return res.data.data;
  };

  // STORE PRODUCT
  const addProduct = async (formData) => {
    try {
      const response = await apiClient.post("/products", formData, {
        headers: { "Content-Type": "multipart/form-data" },
      });
      queryClient.invalidateQueries({ queryKey: ["products"] });
      return response;
    } catch (error) {
      throw error;
    }
  };

  // UPDATE PRODUCT
  const updateProduct = async (id, formData) => {
    try {
      const response = await apiClient.post(
        `/products/${id}?_method=PUT`,
        formData,
        { headers: { "Content-Type": "multipart/form-data" } }
      );
      queryClient.invalidateQueries({ queryKey: ["products"] });
      return response;
    } catch (error) {
      throw error;
    }
  };

  // DELETE PRODUCT
  const deleteProduct = useMutation({
    mutationFn: async (id) => await apiClient.delete(`/products/${id}`),
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["products"] });
    },
  });

  // GET CATEGORIES
  const getCategories = async () => {
    const res = await apiClient.get("/categories");
    return res.data.data;
  };

  // GET PRODUCTS dengan pagination & filter
  const getProducts = async ({ page = 1, limit = 10, category_id = "", keyword = "" }) => {
    const res = await apiClient.get("/products", {
      params: { page, limit, category_id, keyword },
    });
    return res.data; // berisi { data: [...], meta: {...} }
  };

  // BUAT PESANAN (publik, tanpa login)
  const createOrder = async (payload) => {
    const res = await apiClient.post("/orders", payload);
    queryClient.invalidateQueries({ queryKey: ["products"] });
    queryClient.invalidateQueries({ queryKey: ["product"] });
    return res.data.data;
  };

  // Export PROVIDER
  return (
    <ProductContext.Provider
      value={{
        products,
        isLoading,
        isError,
        getProductById,
        addProduct,
        updateProduct,
        deleteProduct,
        getCategories,
        getProducts,
        createOrder,
      }}
    >
      {children}
    </ProductContext.Provider>
  );
};

export const useProducts = () => useContext(ProductContext);