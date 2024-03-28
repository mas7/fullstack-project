import React from "react";
import { Container, TextField, Button, Typography, Grid } from "@mui/material";
import { useFormik } from "formik";
import * as Yup from "yup";
import axiosInstance from "../../api";
import { useNavigate } from "react-router-dom";
import toast from "react-hot-toast";

const Register = () => {
  const navigate = useNavigate();

  const initialValues = {
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
  };

  const validationSchema = Yup.object().shape({
    name: Yup.string().required("Name is required"),
    email: Yup.string().email("Invalid email").required("Email is required"),
    password: Yup.string()
      .required("Password is required")
      .min(6, "Password must be at least 6 characters"),
    password_confirmation: Yup.string()
      .oneOf([Yup.ref("password"), null], "Passwords must match")
      .required("Confirm Password is required"),
  });

  const handleSubmit = async (values, { setSubmitting, setFieldError }) => {
    try {
      const response = await axiosInstance().post("/register", values);
      localStorage.setItem("auth", response.data.data.token);
      navigate("/");
      toast.success(response.data.message);
    } catch (error) {
      console.error(error);
      if (error.response && error.response.data && error.response.data.errors) {
        const { errors } = error.response.data;
        Object.keys(errors).forEach((field) => {
          setFieldError(field, errors[field][0]);
        });
      } else {
        setFieldError("email", "Registration failed");
      }
      toast.error(error.response.data.message);
    }
    setSubmitting(false);
  };

  const formik = useFormik({
    initialValues,
    validationSchema,
    onSubmit: handleSubmit,
  });

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
            Register
          </Typography>
          <form onSubmit={formik.handleSubmit}>
            <TextField
              name="name"
              label="Name"
              variant="outlined"
              fullWidth
              margin="normal"
              value={formik.values.name}
              onChange={formik.handleChange}
              onBlur={formik.handleBlur}
              helperText={
                formik.errors.name && formik.touched.name && formik.errors.name
              }
              error={formik.errors.name && formik.touched.name}
            />
            <TextField
              name="email"
              label="Email"
              variant="outlined"
              fullWidth
              margin="normal"
              value={formik.values.email}
              onChange={formik.handleChange}
              onBlur={formik.handleBlur}
              helperText={
                formik.errors.email &&
                formik.touched.email &&
                formik.errors.email
              }
              error={formik.errors.email && formik.touched.email}
            />
            <TextField
              name="password"
              label="Password"
              variant="outlined"
              fullWidth
              margin="normal"
              type="password"
              value={formik.values.password}
              onChange={formik.handleChange}
              onBlur={formik.handleBlur}
              helperText={
                formik.errors.password &&
                formik.touched.password &&
                formik.errors.password
              }
              error={formik.errors.password && formik.touched.password}
            />
            <TextField
              name="password_confirmation"
              label="Confirm Password"
              variant="outlined"
              fullWidth
              margin="normal"
              type="password"
              value={formik.values.password_confirmation}
              onChange={formik.handleChange}
              onBlur={formik.handleBlur}
              helperText={
                formik.errors.password_confirmation &&
                formik.touched.password_confirmation &&
                formik.errors.password_confirmation
              }
              error={
                formik.errors.password_confirmation &&
                formik.touched.password_confirmation
              }
            />
            <Button
              variant="contained"
              color="primary"
              sx={{ mt: 2 }}
              fullWidth
              type="submit"
              disabled={formik.isSubmitting}
            >
              Register
            </Button>
          </form>
        </Container>
      </Grid>
    </Grid>
  );
};

export default Register;
