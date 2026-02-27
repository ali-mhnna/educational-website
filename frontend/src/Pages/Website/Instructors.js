import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import Axios, { INSTRUCTORS } from '../../Api/Api';
import '../../Styles/Instructors.css';

export default function Instructors() {
  const navigate = useNavigate();
  const [instructors, setInstructors] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    Axios.get(`/${INSTRUCTORS}`)
      .then(res => {
        console.log('Instructors:', res.data);
        setInstructors(res.data);
        setLoading(false);
      })
      .catch(err => {
        console.error('Error:', err);
        setError('حدث خطأ في تحميل المدرسين');
        setLoading(false);
      });
  }, []);

  if (loading) {
    return (
      <div className="loading-container">
        <div className="spinner"></div>
        <p>جاري تحميل المدرسين...</p>
      </div>
    );
  }

  if (error) {
    return (
      <div className="error-container">
        <p>{error}</p>
      </div>
    );
  }

  return (
    <div className="instructors-page">
      {/* Page Header */}
      <section className="instructors-header">
        <div className="container">
          <h1>المدرسون</h1>
          <p>تعرّف على نخبة من أفضل المدرسين في مختلف المجالات</p>
        </div>
      </section>

      {/* Instructors Grid */}
      <section className="instructors-section">
        <div className="container">
          <div className="instructors-grid">
            {instructors.map(instructor => (
              <div 
                key={instructor.id} 
                className="instructor-card"
                onClick={() => navigate(`/instructors/${instructor.id}`)}
              >
                <div className="instructor-avatar">
                  <img 
                    src={instructor.avatar || 'https://via.placeholder.com/300'} 
                    alt={instructor.name}
                    onError={(e) => {
                      e.target.src = 'https://via.placeholder.com/300?text=No+Image';
                    }}
                  />
                </div>

                <div className="instructor-info">
                  <h3 className="instructor-name">{instructor.name}</h3>
                  <p className="instructor-specialization">
                    📚 {instructor.specialization}
                  </p>

                  <div className="instructor-meta">
                    <div className="meta-item">
                      <span className="icon">⭐</span>
                      <span>{instructor.rating}</span>
                    </div>
                    <div className="meta-item">
                      <span className="icon">💼</span>
                      <span>{instructor.experience_years} سنوات</span>
                    </div>
                  </div>

                  <div className="instructor-courses-count">
                    <span className="count">{instructor.courses_count}</span>
                    <span className="label">كورس</span>
                  </div>

                  <button className="view-profile-btn">
                    عرض الملف الشخصي
                  </button>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>
    </div>
  );
}