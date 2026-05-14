<template>
  <div class="fee-type-list">
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Fee Types</h3>
            <div class="card-tools">
              <input
                v-model="search"
                type="text"
                class="form-control form-control-sm"
                placeholder="Search fee types..."
                style="width: 200px;"
              >
            </div>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr><th>Name</th><th>Amount</th><th>Status</th><th>Actions</th></tr>
              </thead>
              <tbody>
                <tr v-for="feeType in filteredFeeTypes" :key="feeType.id">
                  <td>{{ feeType.name }}</td>
                  <td>{{ Number(feeType.amount).toFixed(2) }}</td>
                  <td>
                    <span :class="statusBadge(feeType.status)">{{ feeType.status }}</span>
                  </td>
                  <td>
                    <button class="btn btn-warning btn-sm" @click="editFeeType(feeType)"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-danger btn-sm" @click="confirmDelete(feeType)"><i class="fas fa-trash"></i></button>
                  </td>
                </tr>
                <tr v-if="filteredFeeTypes.length === 0">
                  <td colspan="4" class="text-center">No fee types found.</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">{{ editingFeeType ? 'Edit Fee Type' : 'Add Fee Type' }}</h3>
          </div>
          <div class="card-body">
            <form @submit.prevent="saveFeeType">
              <div class="form-group">
                <label>Name <span class="text-danger">*</span></label>
                <input v-model="form.name" type="text" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Amount <span class="text-danger">*</span></label>
                <input v-model.number="form.amount" type="number" class="form-control" step="0.01" required>
              </div>
              <div class="form-group">
                <label>Status</label>
                <select v-model="form.status" class="form-control">
                  <option value="active">Active</option>
                  <option value="inactive">Inactive</option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary btn-block">{{ editingFeeType ? 'Update' : 'Save' }}</button>
              <button v-if="editingFeeType" type="button" class="btn btn-secondary btn-block" @click="resetForm">Cancel</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'FeeTypeList',
  props: {
    initialFeeTypes: { type: Array, required: true },
    storeUrl: { type: String, required: true },
    baseUrl: { type: String, required: true },
  },
  data() {
    return {
      feeTypes: this.initialFeeTypes,
      search: '',
      editingFeeType: null,
      form: { name: '', amount: 0, status: 'active' },
    };
  },
  computed: {
    filteredFeeTypes() {
      if (!this.search) return this.feeTypes;
      const q = this.search.toLowerCase();
      return this.feeTypes.filter(ft => ft.name.toLowerCase().includes(q));
    },
  },
  methods: {
    statusBadge(status) {
      return status === 'active' ? 'badge badge-success' : 'badge badge-secondary';
    },
    editFeeType(ft) {
      this.editingFeeType = ft;
      this.form = { ...ft };
    },
    resetForm() {
      this.editingFeeType = null;
      this.form = { name: '', amount: 0, status: 'active' };
    },
    async saveFeeType() {
      try {
        if (this.editingFeeType) {
          await axios.put(`${this.baseUrl}/${this.editingFeeType.id}`, this.form);
          window.Swal.fire('Success', 'Fee type updated successfully.', 'success');
          const index = this.feeTypes.findIndex(ft => ft.id === this.editingFeeType.id);
          if (index !== -1) this.feeTypes[index] = { ...this.form, id: this.editingFeeType.id };
        } else {
          const response = await axios.post(this.storeUrl, this.form);
          window.Swal.fire('Success', 'Fee type created successfully.', 'success');
          this.feeTypes.push(response.data.feeType || { ...this.form, id: Date.now() });
        }
        this.resetForm();
      } catch (error) {
        window.Swal.fire('Error', error.response?.data?.message || 'Failed to save fee type.', 'error');
      }
    },
    confirmDelete(ft) {
      window.Swal.fire({
        title: 'Are you sure?',
        text: `Delete fee type "${ft.name}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
      }).then((result) => {
        if (result.isConfirmed) {
          this.deleteFeeType(ft.id);
        }
      });
    },
    async deleteFeeType(id) {
      try {
        await axios.delete(`${this.baseUrl}/${id}`);
        window.Swal.fire('Deleted!', 'Fee type has been deleted.', 'success');
        this.feeTypes = this.feeTypes.filter(ft => ft.id !== id);
        if (this.editingFeeType && this.editingFeeType.id === id) this.resetForm();
      } catch (error) {
        window.Swal.fire('Error', 'Failed to delete fee type.', 'error');
      }
    },
  },
};
</script>
