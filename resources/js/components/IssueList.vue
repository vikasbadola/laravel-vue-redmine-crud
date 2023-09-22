<template>
    <div>
      <div class="d-flex justify-content-between">
                <div class="d-flex">
                    <button @click="addIssue" type="button" class="mb-2 btn btn-primary">
                        <i class="fa fa-plus-circle mr-1"></i>
                        Add Issue
                    </button>
                </div>
                <div class="form-group d-flex">
                    <input type="text" class="form-control" @keyup.enter="getIssues" placeholder="Search..." v-model="searchQuery">
                    &nbsp;
                    <button @click="getIssues" class="btn btn-sm btn-primary">Search</button>
                </div>
            </div>
        <table class="table">
            <tbody v-if="issues.data.length > 0">
                <tr v-for="issue in issues.data" :key="issue.id">
                    <td>
                        <strong>Issue ID:</strong> {{ issue.id }}<br>
                        <strong>Subject:</strong> {{ issue.subject }}<br>
                        <strong>Description:</strong> {{ issue.description }}<br>
                        <strong>Priority:</strong> {{ issue.priority.name }}<br>
                        <strong>Status:</strong> {{ issue.status.name }}
                        <a class="float-end ms-3" href="#" @click="editIssue(issue)"><i class="fa fa-edit"></i></a>
                        <a class="float-end" href="#" @click="confirmIssueDeletion(issue.id)"><i class="fa fa-trash text-danger ms-3"></i></a>
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="6" class="text-center">No records found...</td>
                </tr>
            </tbody>
        </table>
        <Pagination :data="issues" @pagination-change-page="getIssues" />
    </div>
    <div class="modal fade" ref="formContainer" id="issueFormModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        <span v-if="editing">Edit Issue</span>
                        <span v-else>Add New Issue</span>
                    </h5>
                </div>
                <Form ref="form" @submit="handleSubmit" :validation-schema="editing ? editIssueSchema : createIssueSchema"
                    v-slot="{ errors }" :initial-values="formValues">
                    <div class="modal-body"> 
                        <div class="form-group">
                            <label for="project">Project</label>
                            <Field name="project" as="select" class="form-control" 
                                :class="{ 'is-invalid': errors.project }"
                                id="project" aria-describedby="nameHelp" placeholder="Select Project"
                            >
                                <option v-for="project in projects" :value="project.id" :key="project.id" :selected="(project.id === project.id)">{{ project.name }}</option>
                            </Field>
                            <span class="invalid-feedback">{{ errors.project }}</span>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <Field name="subject" type="text" class="form-control" 
                                :class="{ 'is-invalid': errors.subject }"
                                id="subject" aria-describedby="nameHelp" placeholder="Enter Subject" />
                            <span class="invalid-feedback">{{ errors.subject }}</span>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <Field name="description" as="textarea" class="form-control"
                                id="description" aria-describedby="nameHelp" cols="50" rows="2"/>
                        </div>
                        <div class="form-group">
                            <label for="priority" class="form-label">Priority:</label>
                            <Field name="priority" as="select" class="form-control" :class="{ 'is-invalid': errors.priority }"
                                id="priority" aria-describedby="nameHelp" placeholder="Select Priority"
                            >
                                <option v-for="priority in priorities" :value="priority.id" :key="priority.id" :selected="(priority.id === priority.id)">{{ priority.name }}</option>
                            </Field>
                            <span class="invalid-feedback">{{ errors.priority }}</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button @click="closeModal" type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary">Save</button>
                    </div>
                </Form>
            </div>
        </div>
    </div>
    <div class="modal fade" ref="formContainerDelete" id="deleteIssueModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        <span>Delete Issue</span>
                    </h5>
                </div>
                <div class="modal-body">
                    <h5>Are you sure you want to delete this issue ?</h5>
                </div>
                <div class="modal-footer">
                    <button @click="closeDeleteModal" type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button @click.prevent="deleteIssue" type="button" class="btn btn-primary">Delete Issue</button>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup>
import axios from 'axios';
import { ref, onMounted, reactive, watch } from 'vue';
import { Form, Field} from 'vee-validate';
import * as yup from 'yup';
import { useToastr } from '../toastr.js';
import { debounce } from 'lodash';
import { Modal } from 'bootstrap'
import { useLoading } from 'vue3-loading-overlay';
import 'vue3-loading-overlay/dist/vue3-loading-overlay.css';

const toastr = useToastr();
const issues = ref({'data': []});
const projects = ref({'data': []});
const priorities = ref({'data': []});
const editing = ref(false);
const formValues = ref();
const form = ref(null);
const formContainer = ref(null);
const formContainerDelete = ref(null);
let issueModal;
let issueDeleteModal;
let loader = useLoading();

onMounted(() => {
    getIssues();
    getProjects();
    getPriorities();
    issueModal = new Modal(document.getElementById('issueFormModal'));
    issueDeleteModal = new Modal(document.getElementById('deleteIssueModal'));
});

const closeModal = () => {
    issueModal.hide();
}

const closeDeleteModal = () => {
    issueDeleteModal.hide();
}

const getIssues = async(page = 1) => {
    loader.show();
    await axios.get(`/api/issues?page=${page}`, {
        params: {
            query: searchQuery.value
        }
    })
    .then((response) => {
        issues.value = response.data;
        loader.hide();
    })
}

const createIssueSchema = yup.object({
    project: yup.number().required(),
    subject: yup.string().required(),
    description: yup.string(),
    priority: yup.number().required(),
});

const editIssueSchema = yup.object({
    project: yup.number().required(),
    subject: yup.string().required(),
    description: yup.string(),
    priority: yup.number().required(),
});

const createIssue = async(values, { resetForm, setErrors }) => {
    loader.show({
        container: formContainer.value,
    });
    await axios.post('/api/issues', values)
        .then((response) => {
            issues.value= response.data;
            issueModal.hide();
            resetForm();
            loader.hide();
            toastr.success('Issue created successfully!');
        })
        .catch((error) => {
            loader.hide();
            if (error) {
                setErrors(error);
            }
        })
};

const addIssue = () => {
    editing.value = false;
    issueModal.show();
};

const editIssue = (issue) => {
    editing.value = true;
    form.value.resetForm();
    issueModal.show();
    formValues.value = {
        id: issue.id,
        project: issue.project.id,
        subject: issue.subject,
        description: issue.description,
        priority: issue.priority.id,
    };
};

const getProjects = async() => {
    await axios.get(`/api/projects`)
    .then((response) => {
        projects.value = response.data;
    })
    .catch((error) => {
    })
}

const getPriorities = async() => {
    await axios.get(`/api/priorities`)
    .then((response) => {
        priorities.value = response.data;
    })
    .catch((error) => {
    })
}

const updateIssue = async(values, { setErrors }) => {
    loader.show({
        container: formContainer.value,
    });
    await axios.put('/api/issues/' + formValues.value.id, values)
        .then((response) => {
            issues.value= response.data;
            issueModal.hide();
            loader.hide();
            toastr.success('Issue updated successfully!');
        }).catch((error) => {
            loader.hide();
            setErrors(error);
        });
}

const handleSubmit = (values, actions) => {
    if (editing.value) {
        updateIssue(values, actions);
    } else {
        createIssue(values, actions);
    }
}

const searchQuery = ref(null);

const issueIdDeleted = ref(null);
const confirmIssueDeletion = (id) => {
    issueIdDeleted.value = id;
    issueDeleteModal.show();
};

const deleteIssue = async() => {
    loader.show({
        container: formContainerDelete.value,
    });
    await axios.delete(`/api/issues/${issueIdDeleted.value}`)
    .then((response) => {
        issues.value= response.data;
        issueDeleteModal.hide();
        toastr.success('Issue deleted successfully!');
        loader.hide();
    });
};

// watch(searchQuery, debounce(() => {
//     getIssues();
// }, 300));

</script>
