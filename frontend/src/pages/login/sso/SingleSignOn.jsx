import { Button, Container, Grid, TextField, Typography } from "@mui/material";
import React, { useState } from "react";
import toast from "react-hot-toast";
import axiosInstance from "../../../api";

const SingleSignOn = () => {
  const [email, setEmail] = useState("");
  const [error, setError] = useState("");

  const handleSendLink = async () => {
    try {
      const response = await axiosInstance().post("/generate-sso-link", {
        email,
      });
      toast.success(response.data.message);
    } catch (error) {
      setError(error.response?.data.message);
      toast.error(error.response?.data.message);
    }
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
            Single Sign-On
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
          <Button
            variant="contained"
            color="primary"
            sx={{ mt: 2 }}
            fullWidth
            onClick={handleSendLink}
          >
            Send Link
          </Button>
        </Container>
      </Grid>
    </Grid>
  );
};

export default SingleSignOn;
