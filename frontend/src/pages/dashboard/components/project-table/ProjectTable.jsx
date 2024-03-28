import React, { useEffect, useState } from "react";
import {
  Table,
  TableHead,
  TableBody,
  TableRow,
  TableCell,
  TablePagination,
  Button,
  Typography,
  Container,
} from "@mui/material";
import axiosInstance from "../../../../api";
import { Link, useNavigate } from "react-router-dom";
import toast from "react-hot-toast";

const ProjectTable = () => {
  const [projects, setProjects] = useState([]);
  const [page, setPage] = useState(0);
  const [rowsPerPage, setRowsPerPage] = useState(10);
  const [totalPages, setTotalPages] = useState(0);
  const [isLoading, setIsLoading] = useState(true);
  const navigate = useNavigate();

  useEffect(() => {
    fetchProjects();
  }, [page, rowsPerPage]);

  const fetchProjects = async () => {
    try {
      setIsLoading(true);
      const response = await axiosInstance().get(
        `/projects?page=${page + 1}&limit=${rowsPerPage}`
      );
      setProjects(response.data.data.data);
      setTotalPages(response.data.data.last_page);
      setIsLoading(false);
    } catch (error) {
      console.error("Error fetching projects:", error);
      toast.error(error.response.data.message);
      setIsLoading(false);
    }
  };

  const handleChangePage = (event, newPage) => {
    setPage(newPage);
  };

  const handleChangeRowsPerPage = (event) => {
    setRowsPerPage(parseInt(event.target.value, 10));
    setPage(0);
  };

  const handleUpdateProject = (projectId) => {
    navigate(`/projects/update-project/${projectId}`);
  };

  const handleDeleteProject = async (projectId) => {
    try {
      const response = await axiosInstance().delete(`/projects/${projectId}`);
      fetchProjects();
      toast.success(response.data.message);
    } catch (error) {
      console.error("Error deleting project:", error);
      toast.error(error.response.data.message);
    }
  };

  const handleSendEmails = async () => {
    try {
      const response = await axiosInstance().post("/users/send-emails");
      console.log("Emails sent successfully");
      toast.success(response.data.message);
    } catch (error) {
      console.error("Error sending emails:", error);
      toast.error(error.response.data.message);
    }
  };

  return (
    <Container>
      <div
        style={{
          display: "flex",
          justifyContent: "flex-end",
          marginTop: "20px",
        }}
      >
        <Button
          variant="contained"
          color="success"
          style={{ marginRight: "20px" }}
          onClick={handleSendEmails}
        >
          Send Email To Users
        </Button>
        <Button
          component={Link}
          to="/projects/create-project"
          variant="contained"
          color="primary"
        >
          Create New Project
        </Button>
      </div>

      <Typography mt={2} variant="h6" component="h6">
        Projects
      </Typography>
      {isLoading ? (
        <p>Loading...</p>
      ) : (
        <>
          <Table>
            <TableHead>
              <TableRow>
                <TableCell>ID</TableCell>
                <TableCell>Name</TableCell>
                <TableCell>Price</TableCell>
                <TableCell>Created At</TableCell>
                <TableCell>Updated At</TableCell>
                <TableCell>Actions</TableCell>
              </TableRow>
            </TableHead>
            <TableBody>
              {projects?.length > 0 ? (
                projects.map((project) => (
                  <TableRow key={project.id}>
                    <TableCell>{project.id}</TableCell>
                    <TableCell>{project.name}</TableCell>
                    <TableCell>{project.price}</TableCell>
                    <TableCell>{project.created_at}</TableCell>
                    <TableCell>{project.updated_at}</TableCell>
                    <TableCell>
                      <Button
                        onClick={() => handleUpdateProject(project.id)}
                        variant="contained"
                        color="primary"
                        style={{ marginRight: "10px" }}
                      >
                        Update
                      </Button>
                      <Button
                        onClick={() => handleDeleteProject(project.id)}
                        variant="contained"
                        color="error"
                      >
                        Delete
                      </Button>
                    </TableCell>
                  </TableRow>
                ))
              ) : (
                <TableRow>
                  <TableCell colSpan={6}>No projects found</TableCell>
                </TableRow>
              )}
            </TableBody>
          </Table>
          <TablePagination
            rowsPerPageOptions={[5, 10, 25]}
            component="div"
            count={totalPages * rowsPerPage}
            rowsPerPage={rowsPerPage}
            page={page}
            onPageChange={handleChangePage}
            onRowsPerPageChange={handleChangeRowsPerPage}
          />
        </>
      )}
    </Container>
  );
};

export default ProjectTable;
