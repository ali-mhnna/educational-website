import axios from 'axios';
import Cookie from 'cookie-universal';


export const baseUrl = 'http://127.0.0.1:8000/api';

const cookie = Cookie();


const Axios = axios.create({
    baseURL: baseUrl,
    headers: {
        'Content-Type': 'application/json'
    }
});


Axios.interceptors.request.use(
    (config) => {
        const token = cookie.get('educational-token');
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    (error) => Promise.reject(error)
);


export default Axios;



// Authentication
export const REGISTER = 'register';
export const LOGIN = 'login';
export const LOGOUT = 'logout';
export const USER = 'user';

// Courses
export const COURSES = 'courses';
export const COURSES_FEATURED = 'courses/featured';
export const COURSE_BY_ID = 'courses'; // courses/{id}

// Admin
export const ADMIN_COURSES = 'admin/courses';
export const ADMIN_USERS = 'admin/users';

// Instructors
export const INSTRUCTORS = 'instructors';
export const INSTRUCTOR_BY_ID = 'instructors'; // instructors/{id}
export const ADMIN_INSTRUCTORS = 'admin/instructors';

// Enrollment
export const ENROLL_COURSE = 'courses'; // courses/{id}/enroll
export const MY_COURSES = 'my-courses';
export const CHECK_ENROLLMENT = 'courses'; // courses/{id}/check-enrollment


export const ADMIN_ENROLLMENTS = 'admin/enrollments';
export const ADMIN_COURSE_STUDENTS = 'admin/courses'; // admin/courses/{id}/students