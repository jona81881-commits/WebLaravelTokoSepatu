import { createContext, useContext, useEffect, useState } from "react";

const CartContext = createContext();
const STORAGE_KEY = "josepa_cart";

const loadCart = () => {
  try {
    return JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
  } catch {
    return [];
  }
};

export const CartProvider = ({ children }) => {
  const [cart, setCart] = useState(loadCart);

  useEffect(() => {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(cart));
  }, [cart]);

  const addToCart = (product, qty = 1) => {
    setCart((prev) => {
      const found = prev.find((i) => i.id === product.id);
      if (found) {
        return prev.map((i) =>
          i.id === product.id
            ? { ...i, stock: product.stock, qty: Math.min(i.qty + qty, product.stock) }
            : i
        );
      }
      return [
        ...prev,
        {
          id: product.id,
          name: product.name,
          price: product.price,
          img_url: product.img_url,
          category: product.category?.name,
          stock: product.stock,
          qty: Math.min(qty, product.stock),
        },
      ];
    });
  };

  const updateQty = (id, qty) => {
    setCart((prev) =>
      prev.map((i) =>
        i.id === id ? { ...i, qty: Math.max(1, Math.min(qty, i.stock)) } : i
      )
    );
  };

  const removeFromCart = (id) => setCart((prev) => prev.filter((i) => i.id !== id));
  const clearCart = () => setCart([]);

  const totalItems = cart.reduce((sum, i) => sum + i.qty, 0);
  const totalPrice = cart.reduce((sum, i) => sum + i.price * i.qty, 0);

  return (
    <CartContext.Provider
      value={{ cart, setCart, addToCart, updateQty, removeFromCart, clearCart, totalItems, totalPrice }}
    >
      {children}
    </CartContext.Provider>
  );
};

export const useCart = () => useContext(CartContext);