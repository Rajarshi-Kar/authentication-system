import React, { useState, useEffect } from 'react';
import { Container, Table, Alert, Spinner, Card } from 'react-bootstrap';
import { authService } from '../services/apiClient';
import './Teachers.css';

function Teachers() {
  const [teachers, setTeachers] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');

  useEffect(() => {
    fetchTeachers();
  }, []);

  const fetchTeachers = async () => {
    try {
      setLoading(true);
      const response = await authService.getAllTeachers();
      setTeachers(response.data.data);
    } catch (err) {
      setError(err.response?.data?.message || 'Failed to fetch teachers');
    } finally {
      setLoading(false);
    }
  };

  if (loading) {
    return (
      <div className="teachers-container">
        <Container className="text-center py-5">
          <Spinner animation="border" variant="light" />
          <p className="mt-3" style={{ color: 'white' }}>Loading teachers...</p>
        </Container>
      </div>
    );
  }

  return (
    <div className="teachers-container">
      <Container className="py-5">
        <h1 className="mb-4 text-white">📚 Teachers Directory</h1>

        {error && <Alert variant="danger">{error}</Alert>}

        {teachers.length === 0 ? (
          <Card className="text-center">
            <Card.Body>
              <p>No teachers found</p>
            </Card.Body>
          </Card>
        ) : (
          <Card className="table-card">
            <Card.Body className="p-0">
              <div className="table-responsive">
                <Table striped hover className="mb-0 custom-table">
                  <thead>
                    <tr className="table-header">
                      <th>ID</th>
                      <th>Email</th>
                      <th>Name</th>
                      <th>University</th>
                      <th>Gender</th>
                      <th>Year Joined</th>
                      <th>Specialization</th>
                    </tr>
                  </thead>
                  <tbody>
                    {teachers.map((teacher) => (
                      <tr key={teacher.id} className="table-row">
                        <td className="cell-id">{teacher.id}</td>
                        <td className="cell-email">{teacher.email}</td>
                        <td className="cell-name">
                          {teacher.first_name} {teacher.last_name}
                        </td>
                        <td className="cell-university">
                          {teacher.university_name}
                        </td>
                        <td className="cell-gender">
                          <span className={`badge bg-${teacher.gender === 'Male' ? 'primary' : 'danger'}`}>
                            {teacher.gender}
                          </span>
                        </td>
                        <td className="cell-year">{teacher.year_joined}</td>
                        <td className="cell-specialization">
                          {teacher.specialization || '-'}
                        </td>
                      </tr>
                    ))}
                  </tbody>
                </Table>
              </div>
            </Card.Body>
          </Card>
        )}

        <Card className="mt-4 info-card">
          <Card.Body>
            <h5>ℹ️ Information</h5>
            <p className="mb-0">
              Total Teachers: <strong>{teachers.length}</strong>
            </p>
          </Card.Body>
        </Card>
      </Container>
    </div>
  );
}

export default Teachers;
