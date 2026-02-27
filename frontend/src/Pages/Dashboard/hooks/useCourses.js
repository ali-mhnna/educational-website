import { useState, useEffect } from "react";
import Axios, { COURSES, ADMIN_COURSES, INSTRUCTORS } from "../../../Api/Api";

export default function useCourses() {
  const [courses, setCourses] = useState([]);
  const [instructors, setInstructors] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    loadCourses();
    loadInstructors();
  }, []);

    //  جلب الكورسات  (مع بيانات المدرسين)
  function loadCourses() {
    setLoading(true);
    Axios.get(`/${COURSES}`)
      .then((res) => {
        setCourses(res.data);
        setLoading(false);
      })
      .catch((err) => {
        console.error(err);
        setLoading(false);
      });
  }

      // جلب المدرسين
  function loadInstructors() {
    Axios.get(`/${INSTRUCTORS}`)
      .then((res) => {
        setInstructors(res.data);
      })
      .catch((err) => {
        console.error(err);
      });
  }
         
      //  handleDelete
  async function handleDelete(id, title) {
    if (!window.confirm(`هل أنت متأكد من حذف الكورس "${title}"؟`)) {
      return;
    }

    try {
      await Axios.delete(`/${ADMIN_COURSES}/${id}`);
      alert("تم حذف الكورس بنجاح ✅");
      loadCourses();
    } catch (error) {
      console.error(error);
      alert("حدث خطأ في الحذف");
    }
  }
       
      // handleSubmit
  async function handleSubmit(formData, editMode, currentCourse) {
    try {
      const dataToSend = {
        ...formData,
        instructor_id: parseInt(formData.instructor_id),
        is_featured: formData.is_featured ? true : false,
      };

      if (editMode) {
        await Axios.put(`/${ADMIN_COURSES}/${currentCourse.id}`, dataToSend);
        alert("تم تعديل الكورس بنجاح ✅");
      } else {
        await Axios.post(`/${ADMIN_COURSES}`, dataToSend);
        alert("تم إضافة الكورس بنجاح ✅");
      }

      loadCourses();
      return true;
    } catch (error) {
      console.error(error);
      alert("حدث خطأ: " + (error.response?.data?.message || "حاول مرة أخرى"));
      return false;
    }
  }

  return {
    courses,
    instructors,
    loading,
    handleDelete,
    handleSubmit,
    loadCourses,
  };
}