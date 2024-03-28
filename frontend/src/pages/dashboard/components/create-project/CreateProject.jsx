import React from "react";
import { Container, TextField, Button, Typography, Grid } from "@mui/material";
import { useFormik } from "formik";
import * as Yup from "yup";
import { useNavigate } from "react-router-dom";
import axiosInstance from "../../../../api";
import toast from "react-hot-toast";

const CreateProject = () => {
  const navigate = useNavigate();

  const initialValues = {
    name: "",
    price: "",
  };

  const validationSchema = Yup.object().shape({
    name: Yup.string().required("Name is required"),
    price: Yup.number().min(1).required("Price is required"),
  });

  const handleSubmit = async (values, { setSubmitting, setFieldError }) => {
    try {
      const response = await axiosInstance().post("/projects", values);
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
        setFieldError("name", "Creation failed");
      }
    }
    toast.error(error.response.data.message);
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
            Create Project
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
              name="price"
              label="Price"
              variant="outlined"
              fullWidth
              margin="normal"
              value={formik.values.price}
              onChange={formik.handleChange}
              onBlur={formik.handleBlur}
              helperText={
                formik.errors.price &&
                formik.touched.price &&
                formik.errors.price
              }
              error={formik.errors.price && formik.touched.price}
            />
            <Button
              variant="contained"
              color="primary"
              sx={{ mt: 2 }}
              fullWidth
              type="submit"
              disabled={formik.isSubmitting}
            >
              Create
            </Button>
          </form>
        </Container>
      </Grid>
    </Grid>
  );
};

export default CreateProject;
