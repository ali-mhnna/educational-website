import { useState, useEffect } from "react";
import Axios, { ADMIN_ENROLLMENTS, ADMIN_COURSE_STUDENTS } from "../../../../Api/Api";

export default function useEnrollments() {
  const [courses, setCourses] = useState([]);
  const [loading, setLoading] = useState(true);
  const [students, setStudents] = useState([]);
  const [studentsLoading, setStudentsLoading] = useState(false);

  useEffect(() => {
    loadCourses();
  }, []);

  function loadCourses() {
    setLoading(true);
    Axios.get(`/${ADMIN_ENROLLMENTS}`)
      .then((res) => {
        setCourses(res.data);
        setLoading(false);
      })
      .catch((err) => {
        console.error(err);
        setLoading(false);
      });
  }

  async function loadStudents(courseId) {
    setStudentsLoading(true);
    try {
      const res = await Axios.get(`/${ADMIN_COURSE_STUDENTS}/${courseId}/students`);
      setStudents(res.data.students);
      setStudentsLoading(false);
    } catch (err) {
      console.error(err);
      setStudentsLoading(false);
    }
  }

  function clearStudents() {
    setStudents([]);
  }

  return {
    courses,
    loading,
    students,
    studentsLoading,
    loadStudents,
    clearStudents,
  };
}