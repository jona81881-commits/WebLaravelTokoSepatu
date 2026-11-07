import { createContext, useContext, useState } from "react";
import apiClient from "./apiClient";

// Nilai bawaan supaya useAuth() tidak undefined walau provider belum terpasang
const AuthContext = createContext({
  user: null,
  token: null,
  isLoggedIn: false,
  isAdmin: false,
  login: async () => {},
  register: async () => {},
  logout: async () => {},
});

const readStorage = (key) => {
  try {
    return localStorage.getItem(key);
  } catch {
    return null;
  }
};

export const AuthProvider = ({ children }) => {
  const [token, setToken] = useState(() => readStorage("token"));
  const [user, setUser] = useState(() => {
    try {
      return JSON.parse(readStorage("user"));
    } catch {
      return null;
    }
  });

  const saveSession = (data) => {
    setToken(data.token);
    setUser(data.user);
    try {
      localStorage.setItem("token", data.token);
      localStorage.setItem("user", JSON.stringify(data.user));
    } catch {}
  };

  const clearSession = () => {
    setToken(null);
    setUser(null);
    try {
      localStorage.removeItem("token");
      localStorage.removeItem("user");
    } catch {}
  };

  // POST /api/login
  const login = async (email, password) => {
    const res = await apiClient.post("/login", { email, password });
    saveSession(res.data);
    return res.data;
  };

  // POST /api/register
  const register = async (payload) => {
    const res = await apiClient.post("/register", payload);
    saveSession(res.data);
    return res.data;
  };

  // POST /api/logout
  const logout = async () => {
    try {
      await apiClient.post("/logout");
    } catch {
      // token sudah tidak berlaku pun, sesi lokal tetap dihapus
    }
    clearSession();
  };

  const value = {
    user,
    token,
    isLoggedIn: !!token,
    isAuthenticated: !!token,
    isAdmin: !!user?.is_admin,
    login,
    register,
    logout,
  };

  return <AuthContext.Provider value={value}>{children}</AuthContext.Provider>;
};

export const useAuth = () => useContext(AuthContext);