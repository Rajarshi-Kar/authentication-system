import React from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { Navbar as BNavbar, Nav, Container } from 'react-bootstrap';
import './Navbar.css';

function Navbar({ isAuthenticated, onLogout }) {
  const navigate = useNavigate();

  const handleLogout = () => {
    onLogout();
    navigate('/login');
  };

  return (
    <BNavbar bg="dark" expand="lg" sticky="top" className="navbar-custom">
      <Container>
        <BNavbar.Brand as={Link} to="/" className="brand-text">
          🦅 HAWK
        </BNavbar.Brand>
        <BNavbar.Toggle aria-controls="basic-navbar-nav" />
        <BNavbar.Collapse id="basic-navbar-nav">
          <Nav className="ms-auto">
            {isAuthenticated ? (
              <>
                <Nav.Link as={Link} to="/dashboard" className="nav-link">
                  Dashboard
                </Nav.Link>
                <Nav.Link as={Link} to="/teachers" className="nav-link">
                  Teachers List
                </Nav.Link>
                <Nav.Link onClick={handleLogout} className="nav-link logout">
                  Logout
                </Nav.Link>
              </>
            ) : (
              <>
                <Nav.Link as={Link} to="/login" className="nav-link">
                  Login
                </Nav.Link>
                <Nav.Link as={Link} to="/register" className="nav-link">
                  Register
                </Nav.Link>
              </>
            )}
          </Nav>
        </BNavbar.Collapse>
      </Container>
    </BNavbar>
  );
}

export default Navbar;
