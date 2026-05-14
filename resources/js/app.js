import './bootstrap';

import { createApp, ref, computed, reactive, watch, onMounted } from 'vue';
import Swal from 'sweetalert2';
import flatpickr from 'flatpickr';
import TomSelect from 'tom-select';

window.Swal = Swal;
window.flatpickr = flatpickr;
window.TomSelect = TomSelect;

// Expose Vue composition API functions globally for inline scripts
window.Vue = { createApp, ref, computed, reactive, watch, onMounted };

// Components
import StudentList from './components/StudentList.vue';
import StudentForm from './components/StudentForm.vue';
import CourseList from './components/CourseList.vue';
import ClassList from './components/ClassList.vue';
import EnrollmentList from './components/EnrollmentList.vue';
import GuardianList from './components/GuardianList.vue';
import RoomList from './components/RoomList.vue';
import FeeDashboard from './components/FeeDashboard.vue';
import FeeTypeList from './components/FeeTypeList.vue';

const app = createApp({});

app.component('student-list', StudentList);
app.component('student-form', StudentForm);
app.component('course-list', CourseList);
app.component('class-list', ClassList);
app.component('enrollment-list', EnrollmentList);
app.component('guardian-list', GuardianList);
app.component('room-list', RoomList);
app.component('fee-dashboard', FeeDashboard);
app.component('fee-type-list', FeeTypeList);

// Only mount Vue on pages that actually contain Vue component tags.
// Pages rendered entirely by Blade (dashboard, show pages, etc.) will
// skip mounting so their HTML is not wiped by the empty app template.
const mountEl = document.querySelector('#app');
const hasVueComponents = mountEl && mountEl.querySelector(
    'student-list, student-form, course-list, class-list, enrollment-list, guardian-list, room-list, fee-dashboard, fee-type-list'
);

if (mountEl && hasVueComponents) {
    app.mount(mountEl);
}
