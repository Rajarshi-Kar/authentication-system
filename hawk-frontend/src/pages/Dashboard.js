import React, { useState, useEffect } from 'react';
import { Container, Card, Row, Col, Alert, Spinner } from 'react-bootstrap';
import { authService } from '../services/apiClient';
import './Dashboard.css';

function Dashboard() {
  const [profile, setProfile] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');

  useEffect(() => {
    fetchProfile();
  }, []);

  const fetchProfile = async () => {
    try {
      setLoading(true);
      const response = await authService.getProfile();
      setProfile(response.data.data);
    } catch (err) {
      setError(err.response?.data?.message || 'Failed to fetch profile');
    } finally {
      setLoading(false);
    }
  };

  if (loading) {
    return (
      <div className="dashboard-container">
        <Container className="text-center">
          <Spinner animation="border" variant="light" />
          <p className="mt-3" style={{ color: 'white' }}>Loading...</p>
        </Container>
      </div>
    );
  }

  return (
    <div className="dashboard-container">
      <Container className="py-5">
        <h1 className="mb-4 text-white">Welcome to Your Dashboard</h1>

        {error && <Alert variant="danger">{error}</Alert>}

        <Row>
          <Col lg={6} className="mb-4">
            <Card className="profile-card">
              <Card.Header className="card-header-custom">
                <h5 className="mb-0">👤 Personal Information</h5>
              </Card.Header>
              <Card.Body>
                {profile?.user ? (
                  <div className="profile-info">
                    <div className="info-row">
                      <span className="label">Email:</span>
                      <span className="value">{profile.user.email}</span>
                    </div>
                    <div className="info-row">
                      <span className="label">First Name:</span>
                      <span className="value">{profile.user.first_name}</span>
                    </div>
                    <div className="info-row">
                      <span className="label">Last Name:</span>
                      <span className="value">{profile.user.last_name}</span>
                    </div>
                    <div className="info-row">
                      <span className="label">Member Since:</span>
                      <span className="value">
                        {new Date(profile.user.created_at).toLocaleDateString()}
                      </span>
                    </div>
                  </div>
                ) : (
                  <p>No profile data available</p>
                )}
              </Card.Body>
            </Card>
          </Col>

          <Col lg={6} className="mb-4">
            <Card className="profile-card">
              <Card.Header className="card-header-custom">
                <h5 className="mb-0">🎓 Teacher Information</h5>
              </Card.Header>
              <Card.Body>
                {profile?.teacher ? (
                  <div className="profile-info">
                    <div className="info-row">
                      <span className="label">University:</span>
                      <span className="value">{profile.teacher.university_name}</span>
                    </div>
                    <div className="info-row">
                      <span className="label">Gender:</span>
                      <span className="value">{profile.teacher.gender}</span>
                    </div>
                    <div className="info-row">
                      <span className="label">Year Joined:</span>
                      <span className="value">{profile.teacher.year_joined}</span>
                    </div>
                    {profile.teacher.specialization && (
                      <div className="info-row">
                        <span className="label">Specialization:</span>
                        <span className="value">{profile.teacher.specialization}</span>
                      </div>
                    )}
                  </div>
                ) : (
                  <p>No teacher data available</p>
                )}
              </Card.Body>
            </Card>
          </Col>
        </Row>

        <Card className="mt-4 info-card">
          <Card.Body>
            <h5>📋 About Your Account</h5>
            <p>
              This is your personal dashboard where you can view all your profile information.
              Your profile is linked with your teacher information through a secure 1-to-1 relationship.
            </p>
            <p className="mb-0">
              Navigate to <strong>Teachers List</strong> to see all registered teachers in the system.
            </p>
          </Card.Body>
        </Card>
      </Container>
    </div>
  );
}

export default Dashboard;
