import React from "react";
import ReactDOM from "react-dom/client";
import {
  createBrowserRouter,
  Navigate,
  RouterProvider,
} from "react-router-dom";
import App from "./App.jsx";
import "./index.css";
import "@fontsource/roboto/300.css";
import "@fontsource/roboto/400.css";
import "@fontsource/roboto/500.css";
import "@fontsource/roboto/700.css";
import Login from "./pages/login/Login.jsx";
import Register from "./pages/register/Register.jsx";
import Dashboard from "./pages/dashboard/Dashboard.jsx";
import CreateProject from "./pages/dashboard/components/create-project/CreateProject.jsx";
import UpdateProject from "./pages/dashboard/components/update-project/UpdateProject.jsx";
import toast, { Toaster } from "react-hot-toast";

const isAuthenticated = () => {
  return !!localStorage.getItem("auth");
};

const ProtectedRoute = ({ children }) => {
  return isAuthenticated() ? children : <Navigate to="/login" replace />;
};

const UnauthenticatedRoute = ({ element }) => {
  return isAuthenticated() ? <Navigate to="/dashboard" replace /> : element;
};

const router = createBrowserRouter([
  {
    path: "/",
    element: <App />,
  },
  {
    path: "/login",
    element: <UnauthenticatedRoute element={<Login />} />,
  },
  {
    path: "/register",
    element: <UnauthenticatedRoute element={<Register />} />,
  },
  {
    path: "/dashboard",
    element: (
      <ProtectedRoute>
        <Dashboard />
      </ProtectedRoute>
    ),
  },
  {
    path: "/projects/create-project",
    element: (
      <ProtectedRoute>
        <CreateProject />
      </ProtectedRoute>
    ),
  },
  {
    path: "/projects/update-project/:id",
    element: (
      <ProtectedRoute>
        <UpdateProject />
      </ProtectedRoute>
    ),
  },
]);

ReactDOM.createRoot(document.getElementById("root")).render(
  <React.StrictMode>
    <Toaster
      position="top-center"
      reverseOrder={false}
      gutter={8}
      containerClassName=""
      containerStyle={{}}
      toastOptions={{
        duration: 2000,
      }}
    />
    <RouterProvider router={router} />
  </React.StrictMode>
);
