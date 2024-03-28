import React from "react";
import { AppBar, Toolbar, Button, Typography } from "@mui/material";
import { Link, useNavigate } from "react-router-dom";
import ProjectTable from "./components/project-table/ProjectTable";
import axiosInstance from "../../api";
import toast from "react-hot-toast";

const Dashboard = () => {
  const navigate = useNavigate();

  const handleLogout = async () => {
    try {
      const response = await axiosInstance().post("/logout");
      navigate("/login");
      toast.success(response.data.message);
    } catch (error) {
      console.error("Error sending emails:", error);
    }
  };

  return (
    <div>
      <AppBar position="static">
        <Toolbar>
          <div style={{ flexGrow: 1 }}>
            <Link to="/" style={{ textDecoration: "none", color: "inherit" }}>
              <Typography variant="h6" component="h2">
                Dashboard
              </Typography>
            </Link>
          </div>
          <Button variant="contained" color="error" onClick={handleLogout}>
            Logout
          </Button>
        </Toolbar>
      </AppBar>
      <ProjectTable />
    </div>
  );
};

export default Dashboard;
