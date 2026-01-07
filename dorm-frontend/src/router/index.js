import {
  createRouter,
  createWebHistory,
} from 'vue-router';

import About from '../views/About.vue';
import AdminEditDorm from '../views/Admin/AdminEditDorm.vue';
import Amenities from '../views/Admin/Amenities.vue';
import BusRoutes from '../views/Admin/BusRoutes.vue';
// Admin – Data Management
import Categories from '../views/Admin/Categories.vue';
import Dashboard from '../views/Admin/Dashboard.vue';
// Admin – Dorm Management
import Dorms from '../views/Admin/Dorms.vue';
// Admin – Reviews
import Reviews from '../views/Admin/Reviews.vue';
import TrainLines from '../views/Admin/TrainLines.vue';
// Admin – Users
import Users from '../views/Admin/Users.vue';
import ViewDorm from '../views/Admin/ViewDorm.vue';
import Zones from '../views/Admin/Zones.vue';
// Auth
import Login from '../views/Auth/Login.vue';
import Register from '../views/Auth/Register.vue';
import Contact from '../views/Contact.vue';
/* ==============================
   Import Pages
============================== */
// Home
import Home from '../views/Home.vue';

/* ==============================
   Routes
============================== */
const routes = [
  /* ---------- Public Pages ---------- */
{ path: '/', name: 'Home', component: Home },
  { path: '/about', component: About },
  { path: '/contact', component: Contact },

  /* ---------- Auth ---------- */
{ path: '/login', name: 'Login', component: Login },
{ path: '/register', name: 'Register', component: Register },

  { path: '/admin/dashboard', component: Dashboard },

  /* ---------- Admin: Dorm Management ---------- */
  { path: '/admin/dorms', component: Dorms },
  { path: '/admin/dorms/:id', component: ViewDorm },
  { path: '/admin/dorms/:id/edit', component: AdminEditDorm },

  /* ---------- Admin: Master Data ---------- */
  { path: '/admin/categories', component: Categories },
  { path: '/admin/amenities', component: Amenities },
  { path: '/admin/zones', component: Zones },
  { path: '/admin/bus-routes', component: BusRoutes },
  { path: '/admin/train-lines', component: TrainLines },

  /* ---------- Admin: Reviews ---------- */
  { path: '/admin/reviews', component: Reviews },

  /* ---------- Admin: User Management ---------- */
  { path: '/admin/users', component: Users },

  {
  path: "/dorms/category/:type",
  name: "DormCategoryPage",
  component: () => import("../views/DormCategoryPage.vue"),
},

{
  path: "/dorms/:id",
  name: "DormDetail",
  component: () => import("../views/DormDetailPage.vue"),
},

{
  path: "/profile",
  name: "Profile",
  component: () => import("../views/ProfilePage.vue"),
},

{
  path: "/:pathMatch(.*)*",
  name: "NotFound",
  component: () => import("../views/NotFound.vue"),
}

];



/* ==============================
   Router Setup
============================== */
const router = createRouter({
  history: createWebHistory("/app/"),
  routes,
});

/* ==============================
   Route Guards
============================== */
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token');
  const role = localStorage.getItem('role');

  // ปิดการเข้าหน้า admin สำหรับ user ปกติ
  if (to.path.startsWith('/admin') && role !== 'admin') {
    alert('You are not allowed to access admin page');
    return next({ name: 'Login' });

  }

  // ถ้า login แล้ว ไม่ให้กลับไปหน้า login/register
  if ((to.path === '/login' || to.path === '/register') && token) {
if (role === 'admin') return next({ path: '/admin/dorms' });
return next({ path: '/' });
  }

  next();
});

export default router;
