import { useState, useEffect } from "react";
import Cookie from "cookie-universal";
import Axios, { INSTRUCTORS } from "../../../../Api/Api";

export default function useInstructors() {
  const [instructors, setInstructors] = useState([]);
  const [loading, setLoading] = useState(true);
  const cookie = Cookie();

  useEffect(() => {
    loadInstructors();
  }, []);

  function loadInstructors() {
    setLoading(true);
    Axios.get(`/${INSTRUCTORS}`)
      .then((res) => {
        setInstructors(res.data);
        setLoading(false);
      })
      .catch((err) => {
        console.error(err);
        setLoading(false);
      });
  }

  async function handleSubmit(formData, editMode, currentInstructor) {
    try {
      const token = cookie.get("educational-token");
      const data = new FormData();

      data.append("name", formData.name);
      data.append("bio", formData.bio);
      data.append("specialization", formData.specialization);
      data.append("rating", formData.rating);
      data.append("experience_years", formData.experience_years);

      if (formData.avatar) {
        data.append("avatar", formData.avatar);
      }

      let url = "http://127.0.0.1:8000/api/admin/instructors";

      if (editMode) {
        url = `http://127.0.0.1:8000/api/admin/instructors/${currentInstructor.id}`;
        data.append("_method", "PUT");
      }

      const response = await fetch(url, {
        method: "POST",
        headers: {
          Authorization: `Bearer ${token}`,
          Accept: "application/json",
        },
        body: data,
      });

      const result = await response.json();

      if (!response.ok) {
        throw new Error(result.message || "حدث خطأ");
      }

      alert(editMode ? "تم تعديل المدرس بنجاح ✅" : "تم إضافة المدرس بنجاح ✅");
      loadInstructors();
      return true;
    } catch (error) {
      console.error("Error:", error);
      alert("حدث خطأ: " + error.message);
      return false;
    }
  }

  async function handleDelete(id, name) {
    if (!window.confirm(`هل أنت متأكد من حذف المدرس "${name}"؟`)) {
      return;
    }

    try {
      const token = cookie.get("educational-token");

      const response = await fetch(
        `http://127.0.0.1:8000/api/admin/instructors/${id}`,
        {
          method: "DELETE",
          headers: {
            Authorization: `Bearer ${token}`,
            Accept: "application/json",
          },
        }
      );

      const result = await response.json();

      if (!response.ok) {
        throw new Error(result.message || "فشل الحذف");
      }

      alert("تم حذف المدرس بنجاح ✅");
      loadInstructors();
    } catch (error) {
      console.error("Error:", error);
      alert("حدث خطأ في الحذف: " + error.message);
    }
  }

  return {
    instructors,
    loading,
    handleSubmit,
    handleDelete,
  };
}