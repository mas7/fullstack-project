import React, { useEffect } from "react";
import { Container, TextField, Button, Typography, Grid } from "@mui/material";
import { useFormik } from "formik";
import * as Yup from "yup";
import axiosInstance from "../../../../api";
import { useNavigate, useParams } from "react-router-dom";
import toast from "react-hot-toast";

const UpdateProject = () => {
  const { id } = useParams();
  const navigate = useNavigate();

  useEffect(() => {
    fetchProjectDetails();
  }, [id]);

  const fetchProjectDetails = async () => {
    try {
      const response = await axiosInstance().get(`/projects/${id}`);
      formik.setValues(response.data.data);
    } catch (error) {
      console.error("Error fetching project details:", error);
      toast.error(error.response.data.message);
    }
  };

  const validationSchema = Yup.object().shape({
    name: Yup.string().required("Name is required"),
    price: Yup.number().min(1).required("Price is required"),
  });

  const formik = useFormik({
    initialValues: {
      name: "",
      price: "",
    },
    validationSchema: validationSchema,
    onSubmit: async (values, { setSubmitting }) => {
      try {
        const response = await axiosInstance().put(`/projects/${id}`, values);
        navigate("/");
        toast.success(response.data.message);
      } catch (error) {
        console.error("Error updating project:", error);
        toast.error(error.response.data.message);
      }
      setSubmitting(false);
    },
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
            Update Project
          </Typography>
          <form onSubmit={formik.handleSubmit}>
            <TextField
              label="Name"
              variant="outlined"
              fullWidth
              margin="normal"
              {...formik.getFieldProps("name")}
              error={formik.touched.name && formik.errors.name}
              helperText={formik.touched.name && formik.errors.name}
            />
            <TextField
              label="Price"
              variant="outlined"
              fullWidth
              margin="normal"
              {...formik.getFieldProps("price")}
              error={formik.touched.price && formik.errors.price}
              helperText={formik.touched.price && formik.errors.price}
            />
            <Button
              variant="contained"
              color="primary"
              sx={{ mt: 2 }}
              fullWidth
              type="submit"
              disabled={formik.isSubmitting}
            >
              Update
            </Button>
          </form>
        </Container>
      </Grid>
    </Grid>
  );
};

export default UpdateProject;
