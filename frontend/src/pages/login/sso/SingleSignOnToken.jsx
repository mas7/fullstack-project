import React, { useEffect } from "react";
import toast from "react-hot-toast";
import { useNavigate, useParams } from "react-router-dom";

const SingleSignOnToken = () => {
  const { token } = useParams();
  const navigate = useNavigate();

  useEffect(() => {
    localStorage.setItem("auth", token);
    navigate("/dashboard");
    toast.success("Signed in successfully");
  }, []);
  return <div>Signing in....</div>;
};

export default SingleSignOnToken;
