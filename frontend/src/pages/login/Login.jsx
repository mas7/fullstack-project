import React, { useState } from "react";
import { Container, TextField, Button, Typography, Grid } from "@mui/material";
import { useNavigate } from "react-router-dom";
import axiosInstance from "../../api";
import toast from "react-hot-toast";

const Login = () => {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");
  const navigate = useNavigate();

  const handleLogin = async () => {
    try {
      const response = await axiosInstance().post("/login", {
        email,
        password,
      });
      localStorage.setItem("auth", response.data.data.token);
      navigate("/dashboard");
      toast.success(response.data.message);
    } catch (error) {
      setError(error.response.data.message);
      toast.error(error.response.data.message);
    }
  };

  const handleRegister = () => {
    navigate("/register");
  };

  return (
    <Grid
      container
      spacing={0}
      direction="column"
      alignItems="center"
      justifyContent="center"
      sx={{ minHeight: "100vh" }}
    >
      <Grid item xs={3}>
        <Container maxWidth="sm">
          <Typography variant="h4" align="center" gutterBottom>
            Login
          </Typography>
          {error && <Typography color="error">{error}</Typography>}
          <TextField
            label="Email"
            variant="outlined"
            fullWidth
            margin="normal"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
          />
          <TextField
            label="Password"
            variant="outlined"
            fullWidth
            margin="normal"
            type="password"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
          />
          <Button
            variant="contained"
            color="primary"
            sx={{ mt: 2 }}
            fullWidth
            onClick={handleLogin}
          >
            Login
          </Button>
          <Button
            variant="contained"
            color="secondary"
            sx={{ my: 2 }}
            fullWidth
            onClick={handleRegister}
          >
            Register
          </Button>
        </Container>
      </Grid>
    </Grid>
  );
};

export default Login;
