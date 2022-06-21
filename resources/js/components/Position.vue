<template>
    <div id="position">
        <v-row>
            <v-col cols="12" sm="6">
                <v-row>
                    <v-col cols="12" sm="12" md="5">
                        <h3 class="grey--text text--darken-2">
                            <v-icon class="mb-1" color="grey darken-2">mdi-badge-account-outline</v-icon>
                            <span class="text-decoration-underline">{{ $t('position.titleList') }}</span>
                            <v-chip color="grey lighten-2 grey--text text--darken-3">{{
                                positionCount
                            }}</v-chip>
                        </h3>
                    </v-col>
                    <v-col cols="12" sm="12" md="7">
                        <v-text-field
                            v-model="searchAbsent"
                            append-icon="mdi-magnify"
                            class="txt-search"
                            single-line
                            v-bind:label="$t('position.search')"
                        >
                        </v-text-field>
                    </v-col>
                </v-row>
            </v-col>

            <v-col cols="12" sm="6" class="text-end">
                <v-btn small class="add-user white--text pa-2 font-weight-regular mb-2 khawin-background-color"
                    @click="openDialog">
                    <v-icon left>mdi-clipboard-account</v-icon> {{ $t('position.addPosition') }}
                </v-btn>
            </v-col>
        </v-row>

        <!-- -------table---- -->
        <v-card class="mx-auto table-card">
            <v-data-table
                :headers="headers"
                :items="absentData"
                :search="searchAbsent"
                :loading="tableLoading"
                :single-expand="singleExpand"
                :expanded.sync="expanded"
                show-expand
                loading-text="Loading users data"
                :footer-props="{
                    'items-per-page-text':$t('position.tablePagination')
                }"
            >
                <template v-slot:expanded-item="{ headers, item }">
                    <td class="pa-3 employee_count_by_position" :colspan="headers.length">
                        <v-card
                            max-width="400"
                            outlined
                            class="ml-15"
                        >
                            <v-simple-table dense v-if="item.employee.length > 0">
                                <template v-slot:default>
                                    <thead>
                                        <tr>
                                            <th class="text-left">
                                                #
                                            </th>
                                            <th class="text-left">
                                                {{ $t('position.positionEmpProfile') }}
                                            </th>
                                            <th class="text-left">
                                                {{ $t('position.positionEmpName') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(data, index) in item.employee" :key="index">
                                            <td>{{ index + 1 }}.</td>
                                            <td>
                                                <v-avatar
                                                    size="30"
                                                    class="ma-1 white--text"
                                                    left
                                                    v-if="data.pic == 'default.png'"
                                                    :color="'#' + data.profile_color"
                                                >
                                                    {{
                                                    data.name
                                                        .split(" ")
                                                        .map((x) => x[0].toUpperCase())
                                                        .join("")
                                                    }}
                                                </v-avatar>

                                                <v-avatar size="30" class="ma-1" left v-else>
                                                    <v-img :src="'/employees/' + data.pic" />
                                                </v-avatar>
                                            </td>
                                            <td class="font-weight-medium blue-grey--text text--darken-1">{{ data.name }}</td>
                                        </tr>
                                    </tbody>
                                </template>
                            </v-simple-table>

                            <v-simple-table dense v-else>
                                <template v-slot:default>
                                    <thead>
                                        <tr>
                                            <th class="text-left">
                                                #
                                            </th>
                                            <th class="text-left">
                                                Profile
                                            </th>
                                            <th class="text-left">
                                                Name
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>No Employee</td>
                                        </tr>
                                    </tbody>
                                </template>
                            </v-simple-table>

                        </v-card>
                    </td>
                </template>

                <template v-slot:[`item.id`]="item">
                    {{ item.index + 1 }}
                </template>

                <template v-slot:[`item.title`]="{ item }">
                    <v-avatar left>
                        <v-icon color="blue-grey darken-1">mdi-account-star</v-icon>
                    </v-avatar>
                    <span class="text-capitalize blue-grey--text text--darken-2">
                        {{ item.title }}
                    </span>
                </template>

                <template v-slot:[`item.employee_count`]="{ item }">
                    <v-chip
                        class="ma-0 font-weight-medium"
                        color="blue-grey"
                        text-color="white"
                        small
                    >
                        {{ item.employee_count }}
                    </v-chip>
                </template>

                <template v-slot:[`item.actions`]="{ item }">
                    <v-icon small class="mr-2" @click="editPosition(item)">mdi-pencil</v-icon>
                    <v-icon small class="mr-2" @click="deletePosition(item.id, item.title)">mdi-delete</v-icon>
                </template>

                <template v-slot:no-results>
                    <span>{{ $t('position.tabelNotFound') }}</span>
                </template>

            </v-data-table>
        </v-card>

        <!-- --------Absent-Insert-Form------ -->
        <v-dialog v-model="positionForm" width="500" persistent overlay-opacity="0">
            <v-card>
                <v-toolbar dense flat color="lighten-1" class="user-form-dialog khawin-background-color">
                    <span v-if="editMode === false" class="white--text khmer-font">
                        <v-icon left color="white">mdi-badge-account-outline</v-icon>
                        {{ $t('position.formTitleAdd') }}
                    </span>
                    <span v-else class="white--text khmer-font">
                        <v-icon left dark>mdi-badge-account-outline</v-icon>
                         {{ $t('position.formTitleEdit') }}
                    </span>
                </v-toolbar>

                <form @submit.prevent="editMode ? updatePosition() : createPosition()">
                    <v-card-text>
                        <v-text-field
                            v-model="form.title"
                            v-bind:label="$t('position.txtPosition')"
                            outlined
                            prepend-inner-icon="mdi-account-star"
                            class="khmer-font"
                            :error-messages="errorsMessage.title"
                        ></v-text-field>

                    </v-card-text>

                    <v-card-actions class="card-action khmer-font">
                        <v-spacer></v-spacer>
                        <v-btn small color="grey lighten-2" depressed @click="closeDialog">
                            {{ $t('position.btnCancel') }}
                        </v-btn>
                        <v-btn class="khawin-background-color khmer-font" dark small depressed type="submit" :loading="btnSaveLoading">
                            {{ $t('position.btnSave') }}
                        </v-btn>
                    </v-card-actions>
                </form>
            </v-card>
        </v-dialog>

        <!-- ---------------Snacbar--------------- -->
        <v-snackbar v-model="snackbar" color="cyan darken-2" dark>
            {{ alertSnackbarMsg }}
            <template v-slot:action="{ attrs }">
                <v-btn dark text v-bind="attrs" @click="snackbar = false" small>
                    {{ $t('position.msgClose') }}
                </v-btn>
            </template>
        </v-snackbar>

        <!-- ----------dialogDelete------------ -->
        <v-dialog v-model="dialogDelete" max-width="330px">
            <v-card>
                <div class="text-center">
                    <v-sheet class="px-7 pt-7 pb-4 mx-auto text-center d-inline-block">
                        <v-icon class="text-center pb-3" x-large color="red lighten-2">mdi-alert</v-icon>
                        <div class="grey--text text--darken-3 text-body-2 mb-4">
                            {{ $t('position.deleteMessage') }}
                            <b class="red--text tex--lighten-2">{{ positionTitle }}</b>
                            ?
                            <p>{{ $t('position.deleteMessageWarning') }}!</p>
                        </div>

                        <v-btn :disabled="btnLoading" class="ma-1" depressed small @click="dialogDelete = false">
                            {{ $t('position.btnCancel') }}
                        </v-btn>

                        <v-btn :loading="btnLoading" class="ma-1" dark color="red" small depressed
                            @click="submitDelete">
                            {{ $t('position.btnDelete') }}
                        </v-btn>
                    </v-sheet>
                </div>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import moment from "moment";
export default {
    data() {
        return {
            absentDateChoose: false,
            expanded: [],
            singleExpand: false,
            searchAbsent: "",
            snackbar: false,
            editMode: false,
            tableLoading: true,
            absentData: [],
            employeeData: [],
            positionCount: "",
            positionForm: false,
            form: new Form({
                id: "",
                title: ""
            }),
            btnSaveLoading: false,
            btnLoading: false,
            alertSnackbarMsg: "",
            errorsMessage: "",
            dialogDelete: false,
            positionTitle: "",
        };
    },
    computed: {
        formTitle() {
            return this.editMode === false ? "Add Position" : "Edit Position";
        },
        computedDateFormattedMomentjs() {
            return this.form.date
                ? moment(this.form.date).format("dddd, DD/ MM/ YYYY")
                : "";
        },

        // ====================================
        headers(){
            return [
                { text: this.$t('position.positionTable'), value: 'title' },
                { text: this.$t('position.employeeCountTable'), value: 'employee_count' },
                { text: this.$t('position.edit_delete'), sortable: false, align: "center", value: "actions" },
            ]
        }
    },
    mounted() {
        this.ReadPosition();
        this.activateMultipleDraggableDialogs();
    },

    methods: {
        ReadPosition() {
            axios
            .get("http://127.0.0.1:8000/api/read-position", {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("access_token"),
                },
            })
            .then((response) => {
                this.absentData = response.data.data;
                this.positionCount = response.data.data.length;
                this.tableLoading = false;
            })
            .catch((error) => {
                console.log(error);
            });
        },

        openDialog() {
            this.positionForm = true;
        },

        closeDialog() {
            this.editMode = false;
            this.positionForm = false;
            this.form.position_id = "";
            this.form.title = "";
            this.btnSaveLoading = false;
        },

        createPosition() {
            this.btnSaveLoading = true;
            this.tableLoading = true;
            this.form
                .post("api/create-position", {
                    headers: {
                        Authorization: "Bearer " + localStorage.getItem("access_token"),
                    },
                })
                .then((response) => {
                    this.ReadPosition();
                    this.closeDialog();
                    // this.alertSnackbarMsg = response.data.message;
                    this.alertSnackbarMsg = this.$t('position.savedMsg');
                    this.snackbar = true;
                    this.btnSaveLoading = false;
                    this.tableLoading = false;
                })
                .catch((errors) => {
                    this.errorsMessage = errors.response.data.errors;
                    this.btnSaveLoading = false;
                    this.tableLoading = false;
                });
        },

        editPosition(position) {
            this.editMode = true;
            this.form.id = position.id;
            this.form.title = position.title;
            this.positionForm = true;
        },

        async updatePosition() {
            this.btnSaveLoading = true;
            this.tableLoading = true;
            await new Promise((resolve) => setTimeout(resolve, 1000));
            this.form
                .post("/api/update-position/" + this.form.id, {
                    headers: {
                        Authorization: "Bearer " + localStorage.getItem("access_token"),
                    },
                })
                .then((response) => {
                    this.ReadPosition();
                    this.closeDialog();
                    // this.alertSnackbarMsg = response.data.message;
                    this.alertSnackbarMsg = this.$t('position.updateMsg');
                    this.snackbar = true;
                    this.btnSaveLoading = false;
                    this.tableLoading = false;
                })
                .catch((errors) => {
                    this.errorsMessage = errors.response.data.errors;
                    this.btnSaveLoading = false;
                    this.tableLoading = false;
                });
        },

        deletePosition(position, name) {
            this.form.id = position;
            this.positionTitle = name;
            this.dialogDelete = true;
        },

        async submitDelete() {
            this.btnLoading = true;
            this.tableLoading = true;
            await new Promise((resolve) => setTimeout(resolve, 1000));
            axios
                .delete("/api/delete-position/" + this.form.id, {
                    headers: {
                        Authorization: "Bearer " + localStorage.getItem("access_token"),
                    },
                })
                .then((response) => {
                    this.ReadPosition();
                    this.dialogDelete = false;
                    // this.alertSnackbarMsg = response.data.message;
                    this.alertSnackbarMsg = this.$t('position.deleteMsg');
                    this.snackbar = true;
                    this.btnLoading = false;
                    this.tableLoading = false;
                })
                .catch((error) => {
                    this.btnLoading = false;
                    this.tableLoading = false;
                });
        },
    },
};
</script>
