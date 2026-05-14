<template>
  <div class="student-form">
    <form @submit.prevent="submitForm" enctype="multipart/form-data">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label>Student Code <span class="text-danger">*</span></label>
            <input v-model="form.student_code" type="text" class="form-control" required />
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Gender</label>
            <select v-model="form.gender_id" class="form-control">
              <option value="">Select Gender</option>
              <option v-for="g in genders" :key="g.id" :value="g.id">{{ g.name_kh }}</option>
            </select>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Status <span class="text-danger">*</span></label>
            <select v-model="form.status" class="form-control" required>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
              <option value="graduated">Graduated</option>
              <option value="suspended">Suspended</option>
              <option value="dropped">Dropped</option>
            </select>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Name (Khmer) <span class="text-danger">*</span></label>
            <input v-model="form.khmer_name" type="text" class="form-control" required />
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Name (Latin)</label>
            <input v-model="form.latin_name" type="text" class="form-control" />
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label>Date of Birth</label>
            <input ref="dobInput" type="text" class="form-control flatpickr" />
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Phone</label>
            <input v-model="form.phone" type="text" class="form-control" />
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Email</label>
            <input v-model="form.email" type="email" class="form-control" />
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <h5>Birth Place Address</h5>
          <div class="form-group">
            <label>Province</label>
            <select v-model="form.birth_province_id" class="form-control" @change="loadBirthDistricts">
              <option value="">Select Province</option>
              <option v-for="p in provinces" :key="p.id" :value="p.id">{{ p.name_kh }}</option>
            </select>
          </div>
          <div class="form-group">
            <label>District</label>
            <select v-model="form.birth_district_id" class="form-control" @change="loadBirthCommunes">
              <option value="">Select District</option>
              <option v-for="d in birthDistricts" :key="d.id" :value="d.id">{{ d.name_kh }}</option>
            </select>
          </div>
          <div class="form-group">
            <label>Commune</label>
            <select v-model="form.birth_commune_id" class="form-control">
              <option value="">Select Commune</option>
              <option v-for="c in birthCommunes" :key="c.id" :value="c.id">{{ c.name_kh }}</option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <h5>Current Address</h5>
          <div class="form-group">
            <label>Province</label>
            <select v-model="form.current_province_id" class="form-control" @change="loadCurrentDistricts">
              <option value="">Select Province</option>
              <option v-for="p in provinces" :key="p.id" :value="p.id">{{ p.name_kh }}</option>
            </select>
          </div>
          <div class="form-group">
            <label>District</label>
            <select v-model="form.current_district_id" class="form-control" @change="loadCurrentCommunes">
              <option value="">Select District</option>
              <option v-for="d in currentDistricts" :key="d.id" :value="d.id">{{ d.name_kh }}</option>
            </select>
          </div>
          <div class="form-group">
            <label>Commune</label>
            <select v-model="form.current_commune_id" class="form-control">
              <option value="">Select Commune</option>
              <option v-for="c in currentCommunes" :key="c.id" :value="c.id">{{ c.name_kh }}</option>
            </select>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label>Note</label>
        <textarea v-model="form.note" class="form-control" rows="2"></textarea>
      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save"></i> Save Student
        </button>
        <a :href="cancelUrl" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  name: 'StudentForm',
  props: {
    studentData: { type: Object, default: null },
    genders: { type: Array, default: () => [] },
    provinces: { type: Array, default: () => [] },
    submitUrl: { type: String, required: true },
    cancelUrl: { type: String, required: true },
    isEdit: { type: Boolean, default: false },
  },
  data() {
    return {
      form: {
        student_code: '',
        khmer_name: '',
        latin_name: '',
        gender_id: '',
        date_of_birth: '',
        phone: '',
        email: '',
        status: 'active',
        note: '',
        birth_province_id: '',
        birth_district_id: '',
        birth_commune_id: '',
        current_province_id: '',
        current_district_id: '',
        current_commune_id: '',
      },
      birthDistricts: [],
      birthCommunes: [],
      currentDistricts: [],
      currentCommunes: [],
    };
  },
  mounted() {
    if (this.studentData) {
      this.form = { ...this.form, ...this.studentData };
    }
    this.$nextTick(() => {
      if (window.flatpickr && this.$refs.dobInput) {
        window.flatpickr(this.$refs.dobInput, {
          dateFormat: 'Y-m-d',
          defaultDate: this.form.date_of_birth,
          onChange: (selectedDates, dateStr) => {
            this.form.date_of_birth = dateStr;
          },
        });
      }
    });
  },
  methods: {
    async loadBirthDistricts() {
      this.form.birth_district_id = '';
      this.form.birth_commune_id = '';
      this.birthDistricts = [];
      this.birthCommunes = [];
      if (this.form.birth_province_id) {
        const response = await axios.get(`/api/districts?province_id=${this.form.birth_province_id}`);
        this.birthDistricts = response.data;
      }
    },
    async loadBirthCommunes() {
      this.form.birth_commune_id = '';
      this.birthCommunes = [];
      if (this.form.birth_district_id) {
        const response = await axios.get(`/api/communes?district_id=${this.form.birth_district_id}`);
        this.birthCommunes = response.data;
      }
    },
    async loadCurrentDistricts() {
      this.form.current_district_id = '';
      this.form.current_commune_id = '';
      this.currentDistricts = [];
      this.currentCommunes = [];
      if (this.form.current_province_id) {
        const response = await axios.get(`/api/districts?province_id=${this.form.current_province_id}`);
        this.currentDistricts = response.data;
      }
    },
    async loadCurrentCommunes() {
      this.form.current_commune_id = '';
      this.currentCommunes = [];
      if (this.form.current_district_id) {
        const response = await axios.get(`/api/communes?district_id=${this.form.current_district_id}`);
        this.currentCommunes = response.data;
      }
    },
    submitForm() {
      // Let the native form submit handle it since we have file uploads in some forms
      // This Vue component is mainly for enhanced UI (flatpickr, dynamic selects)
      // The actual submission can be done via standard form post or axios
      this.$emit('submit', this.form);
    },
  },
};
</script>
