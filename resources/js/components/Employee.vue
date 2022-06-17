<template>
  <div id="employee">
    <div>
      <v-row>
        <v-col cols="12" sm="6">
          <v-row>
            <v-col cols="12" sm="12" md="5">
              <h3 class="grey--text text--darken-2">
                <v-icon class="mb-1" color="grey darken-2"
                  >mdi-account-tie</v-icon
                >
                <span class="text-decoration-underline">{{ $t('employee.list') }}</span>
              </h3>
            </v-col>
            <v-col cols="12" sm="12" md="6">
                <v-text-field
                    v-show="!cardView"
                    class="txt-search"
                    v-model="searchEmployee"
                    append-icon="mdi-magnify"
                    v-bind:label="$t('employee.search')"
                    single-line
                ></v-text-field>
            </v-col>
          </v-row>
        </v-col>

        <v-col cols="12" sm="6" class="text-end">
            <v-btn
                small
                class="khawin-background-color add-user white--text pa-2 font-weight-regular mb-2"
                @click="openDialog"
            >
                <v-icon left>mdi-plus</v-icon> {{ $t('employee.btnAddEmp') }}
            </v-btn>
        </v-col>
      </v-row>

      <!-- -------table---- -->

      <v-tabs v-model="tab">
        <v-tabs-slider color="transparent"></v-tabs-slider>
        <v-tab class="text-capitalize tab" key="activeEmployee">
          <v-icon class="mr-2" left>mdi-account-multiple</v-icon>
          <span class="font-weight-medium">{{ $t('employee.activeEmp') }}</span>
          <v-chip small class="ml-2 font-weight-medium blue-grey--text text--darken-2">{{
            employeeActiveCount
          }}</v-chip>
        </v-tab>
        <v-tab class="text-capitalize tab" key="inactiveEmployee">
          <v-icon class="mr-2" left>mdi-account-multiple-minus</v-icon>
          <span class="font-weight-medium">{{ $t('employee.inctiveEmp') }}</span>
          <v-chip small class="ml-2 font-weight-medium blue-grey--text text--darken-2">{{
            employeeInactiveCount
          }}</v-chip>
        </v-tab>

        <v-spacer></v-spacer>
        <v-btn
            class="mx-2"
            fab
            small
            icon
            @click="listViewChang"
        >
            <v-icon dark>{{ cardView ? 'mdi-format-list-numbered' : 'mdi-view-grid' }}</v-icon>
        </v-btn>
      </v-tabs>

      <v-tabs-items v-model="tab">
        <v-tab-item key="activeEmployee">
          <v-card class="mx-auto table-card" v-show="!cardView">
            <v-data-table
                :headers="ActiveEmployeeHeaders"
                :items="employeeActiveData"
                :search="searchEmployee"
                :loading="tableLoading"
                loading-text="Loading users data"
                :footer-props="{
                    'items-per-page-text':$t('employee.tablePagination')
                }"
            >
              <template v-slot:[`item.id`]="item">
                {{ item.index + 1 }}
              </template>

              <!-- :color="randomColor()" -->
              <!-- color="cyan darken-2 white--text" -->
              <template v-slot:[`item.name`]="{ item }">
                <v-avatar
                  size="40"
                  class="ma-1 white--text"
                  left
                  v-if="item.image == 'default.png'"
                  :color="'#' + item.profile_color"
                >
                  <span>{{
                    item.name
                      .split(" ")
                      .map((x) => x[0].toUpperCase())
                      .join("")
                  }}</span>
                </v-avatar>

                <v-avatar size="38" class="ma-2" left v-else>
                  <v-img :src="'/employees/' + item.image" />
                </v-avatar>

                <span
                  class="
                    font-weight-bold
                    blue-grey--text
                    text--darken-3 text-capitalize
                    employee-name
                  "
                >
                  {{ item.name }}
                </span>
              </template>

              <template v-slot:[`item.gender`]="{ item }">
                <v-chip
                  v-if="item.gender == 'male'"
                    small
                    color="indigo"
                    text-color="white"
                    class="pl-1 py-0"

                >
                  <v-avatar>
                    <v-icon x-small>mdi-human-male</v-icon>
                  </v-avatar>
                  {{ $t('employee.tbGenderM') }}
                </v-chip>

                <v-chip
                    v-else
                    small
                    color="pink"
                    text-color="white"
                    class="pl-1 py-0"
                >
                    <v-avatar>
                        <v-icon x-small>mdi-human-female</v-icon>
                    </v-avatar>
                    {{ $t('employee.tbGenderF') }}
                </v-chip>
              </template>

                <template v-slot:[`item.position.title`]="{ item }">
                    <v-chip
                        label
                        dark
                        color="blue-grey darken-2"
                        class="text-capitalize pa-1 font-weight-medium"
                        small

                    >
                        <v-avatar left>
                            <v-icon small>mdi-account-star</v-icon>
                        </v-avatar>
                        {{ item.position.title }}
                    </v-chip>
                </template>

                <template v-slot:[`item.start_date`]="{ item }">
                    <v-chip
                        class="pa-1 start-date"
                        small
                        color="teal"
                        text-color="white"
                        label
                    >
                    <v-avatar left>
                        <v-icon x-small>mdi-calendar-month</v-icon>
                    </v-avatar>
                        <span v-if="formatDate(item.start_date).split('/')[1] == 1">
                            {{ formatDate(item.start_date).split('/')[0] }}
                            / {{ $t('employee.january') }}
                            / {{ formatDate(item.start_date).split('/')[2] }}
                        </span>
                        <span v-if="formatDate(item.start_date).split('/')[1] == 2">
                            {{ formatDate(item.start_date).split('/')[0] }}
                            / {{ $t('employee.february') }}
                            / {{ formatDate(item.start_date).split('/')[2] }}
                        </span>
                        <span v-if="formatDate(item.start_date).split('/')[1] == 3">
                            {{ formatDate(item.start_date).split('/')[0] }}
                            / {{ $t('employee.march') }}
                            / {{ formatDate(item.start_date).split('/')[2] }}
                        </span>
                        <span v-if="formatDate(item.start_date).split('/')[1] == 4">
                            {{ formatDate(item.start_date).split('/')[0] }}
                            / {{ $t('employee.april') }}
                            / {{ formatDate(item.start_date).split('/')[2] }}
                        </span>
                        <span v-if="formatDate(item.start_date).split('/')[1] == 5">
                            {{ formatDate(item.start_date).split('/')[0] }}
                            / {{ $t('employee.may') }}
                            / {{ formatDate(item.start_date).split('/')[2] }}
                        </span>
                        <span v-if="formatDate(item.start_date).split('/')[1] == 6">
                            {{ formatDate(item.start_date).split('/')[0] }}
                            / {{ $t('employee.june') }}
                            / {{ formatDate(item.start_date).split('/')[2] }}
                        </span>
                        <span v-if="formatDate(item.start_date).split('/')[1] == 7">
                            {{ formatDate(item.start_date).split('/')[0] }}
                            / {{ $t('employee.july') }}
                            / {{ formatDate(item.start_date).split('/')[2] }}
                        </span>
                        <span v-if="formatDate(item.start_date).split('/')[1] == 8">
                            {{ formatDate(item.start_date).split('/')[0] }}
                            / {{ $t('employee.august') }}
                            / {{ formatDate(item.start_date).split('/')[2] }}
                        </span>
                        <span v-if="formatDate(item.start_date).split('/')[1] == 9">
                            {{ formatDate(item.start_date).split('/')[0] }}
                            / {{ $t('employee.september') }}
                            / {{ formatDate(item.start_date).split('/')[2] }}
                        </span>
                        <span v-if="formatDate(item.start_date).split('/')[1] == 10">
                            {{ formatDate(item.start_date).split('/')[0] }}
                            / {{ $t('employee.october') }}
                            / {{ formatDate(item.start_date).split('/')[2] }}
                        </span>
                        <span v-if="formatDate(item.start_date).split('/')[1] == 11">
                            {{ formatDate(item.start_date).split('/')[0] }}
                            / {{ $t('employee.november') }}
                            / {{ formatDate(item.start_date).split('/')[2] }}
                        </span>
                         <span v-if="formatDate(item.start_date).split('/')[1] == 12">
                            {{ formatDate(item.start_date).split('/')[0] }}
                            / {{ $t('employee.december') }}
                            / {{ formatDate(item.start_date).split('/')[2] }}
                        </span>
                    </v-chip>
                </template>

                <template v-slot:[`item.phone_number`]="{ item }">
                    <span v-for="number in item.phone_number" :key="number.id">
                    <v-chip
                        v-if="number.phone != null"
                        class="pa-1"
                        small
                        color="grey lighten-2"
                        text-color="blue-grey darken-3"
                        label
                    >
                        {{ number.phone }}
                        <v-avatar class="mr-0">
                        <v-icon x-small>mdi-phone</v-icon>
                        </v-avatar>
                    </v-chip>
                    <br />
                    </span>
                </template>

                <template v-slot:[`item.actions`]="{ item }">
                    <v-icon small class="mr-2" @click="editEmployee(item)"
                    >mdi-pencil</v-icon
                    >
                    <v-icon
                    small
                    class="mr-2"
                    @click="deleteEployee(item.id, item.name)"
                    >mdi-delete</v-icon
                    >
                </template>

                <template v-slot:no-results>
                    <span>{{ $t('employee.tabelNotFound') }}</span>
                </template>
            </v-data-table>
          </v-card>

          <!-- card list-->
          <v-card color="grey lighten-4" class="pa-5 table-card" v-show="cardView">
            <v-flex class="d-flex flex-wrap justify-center">
                <v-card
                    v-for="(item, index) in employeeActiveData"
                    :key="index"
                    class="ma-3 employeeCard"
                    width="344"
                    height="210"
                    max-width="344"
                >
                    <v-row class="ma-0">
                        <v-col cols="5">
                            <v-img
                                v-if="item.image == 'default.png'"
                                height="150"
                                width="130"
                                class="mt-5 cardDefaulProfileImg"
                            >
                                <span class="cardEmpName">{{
                                    item.name
                                    .split(" ")
                                    .map((x) => x[0].toUpperCase())
                                    .join("")
                                }}</span>
                            </v-img>

                            <v-img
                                v-else
                                height="150"
                                width="130"
                                :src="'/employees/' + item.image"
                                class="mt-5 cardImg"
                            >
                            </v-img>

                        </v-col>
                        <v-col cols="7" class="cardDetail pa-0">
                            <div class="cardNum">{{ index + 1 }}</div>
                            <h5 class="cardPosition">Junior Software Development</h5>
                            <h4>{{ item.name }}</h4>
                            <p><v-icon x-small>mdi-email</v-icon> {{ item.email }}</p>
                            <p v-if="item.gender == 'male'"><v-icon small>mdi-human-male</v-icon> {{ item.gender }}</p>
                            <p v-if="item.gender == 'female'"><v-icon small>mdi-human-female</v-icon> {{ item.gender }}</p>
                            <p><v-icon x-small>mdi-calendar-month</v-icon> {{ formatDate(item.start_date) }}</p>
                            <span v-for="number in item.phone_number" :key="number.id">
                                <p v-if="number.phone != null" class="cardPhoneNum"><v-icon x-small>mdi-phone</v-icon> {{ number.phone }}</p>
                            </span>

                            <!-- SHAPE -->
                            <div style="position: absolute; bottom: -40px; right: -30px; height: 100px; width: 100px; border-radius: 50%; background: rgb(63 81 181 / 7%);"></div>
                            <div style="position: absolute; bottom: 30px; right: 20px; height: 120px; width: 120px; border-radius: 50%; background: rgb(63 81 181 / 7%);"></div>
                            <div style="position: absolute; bottom: -30px; left: 20px; height: 150px; width: 150px; border-radius: 50%; background: rgb(63 81 181 / 7%); z-index: -1;"></div>

                            <div class="cardAction">
                                <v-icon small class="mr-2" @click="editEmployee(item)">mdi-pencil</v-icon>
                                <v-icon
                                    small
                                    class="mr-2"
                                    @click="deleteEployee(item.id, item.name)"
                                >
                                    mdi-delete
                                </v-icon>
                            </div>
                        </v-col>
                    </v-row>
                </v-card>
            </v-flex>
          </v-card>
        </v-tab-item>

        <v-tab-item key="inactiveEmployee">
          <v-card class="mx-auto table-card">
            <v-data-table
                :headers="InactiveEmployeeHeaders"
                :items="employeeInactiveData"
                :search="searchEmployee"
                :loading="tableLoading"
                loading-text="Loading users data"
                :footer-props="{
                    'items-per-page-text':$t('employee.tablePagination')
                }"
            >
                <template v-slot:[`item.id`]="item">
                    {{ item.index + 1 }}
                </template>

                <template v-slot:[`item.name`]="{ item }">
                    <v-avatar
                        size="40"
                        class="ma-1 white--text"
                        left
                        v-if="item.image == 'default.png'"
                        :color="'#' + item.profile_color"
                    >
                        {{
                            item.name
                            .split(" ")
                            .map((x) => x[0].toUpperCase())
                            .join("")
                        }}
                    </v-avatar>

                    <v-avatar size="38" class="ma-2" left v-else>
                    <v-img :src="'/employees/' + item.image" />
                    </v-avatar>

                    <span
                        class="
                            font-weight-medium
                            blue-grey--text
                            text--darken-3 text-capitalize
                            employee-name
                        "
                    >
                        {{ item.name }}
                    </span>
                </template>

                <template v-slot:[`item.gender`]="{ item }">
                    <v-chip
                    v-if="item.gender == 'male'"
                        small
                        color="indigo"
                        text-color="white"
                        class="pl-1 py-0"

                    >
                    <v-avatar>
                        <v-icon x-small>mdi-human-male</v-icon>
                    </v-avatar>
                        {{ $t('employee.tbGenderM') }}
                    </v-chip>

                    <v-chip
                        v-else
                        small
                        color="pink"
                        text-color="white"
                        class="pl-1 py-0"
                    >
                        <v-avatar>
                            <v-icon x-small>mdi-human-female</v-icon>
                        </v-avatar>
                        {{ $t('employee.tbGenderF') }}
                    </v-chip>
                </template>

                <template v-slot:[`item.position.title`]="{ item }">
                     <v-chip
                        label
                        dark
                        color="blue-grey darken-2"
                        class="text-capitalize pa-1 font-weight-medium"
                        small

                    >
                        <v-avatar left>
                            <v-icon small>mdi-account-star</v-icon>
                        </v-avatar>
                        {{ item.position.title }}
                    </v-chip>
                </template>

                <template v-slot:[`item.start_date`]="{ item }">
                    <v-chip
                        class="p-1 start-date mt-1 font-weight-bold"
                        small
                        color="teal"
                        label
                        outlined
                    >
                        <v-avatar left class="mr-0">
                            <v-icon small>mdi-calendar-arrow-right</v-icon>
                        </v-avatar>
                        {{ formatDate(item.start_date) }}
                    </v-chip>

                    <!-- =======LEAVE==DATE====== -->
                    <br>
                    <v-chip
                        class="p-1 start-date mt-1 mb-1 font-weight-bold"
                        small
                        color="orange darken-3"
                        label
                        outlined
                    >
                        <v-avatar left class="mr-0">
                            <v-icon small>mdi-calendar-arrow-left</v-icon>
                        </v-avatar>
                        {{ formatDate(item.leave_date) }}
                    </v-chip>
                </template>

                <template v-slot:[`item.phone_number`]="{ item }">
                    <span v-for="number in item.phone_number" :key="number.id">
                        <v-chip
                            v-if="number.phone != null"
                            class="p-1 start-date"
                            small
                            color="grey lighten-2"
                            text-color="blue-grey darken-3"
                            label
                        >
                            {{ number.phone }}
                            <v-avatar class="mr-0">
                            <v-icon x-small>mdi-phone</v-icon>
                            </v-avatar>
                        </v-chip>
                        <br />
                    </span>
                </template>

                <template v-slot:[`item.actions`]="{ item }">
                    <v-icon small class="mr-2" @click="editEmployee(item)">mdi-pencil</v-icon>
                    <v-icon
                        small
                        class="mr-2"
                        @click="deleteEployee(item.id, item.name)">
                        mdi-delete
                    </v-icon>
                </template>
                <template v-slot:no-results>
                    <span>{{ $t('employee.tabelNotFound') }}</span>
                </template>
            </v-data-table>
          </v-card>
        </v-tab-item>
      </v-tabs-items>

      <!-- --------employee-Insert-Form------ -->
      <v-dialog
            v-model="employeeForm"
            width="550"
            persistent
            overlay-opacity="0"
      >
        <v-card>
          <v-toolbar
            dense
            flat
            color="lighten-1"
            class="user-form-dialog khawin-background-color"
          >
            <span v-if="editMode === false" class="white--text khmer-font">
                <v-icon left color="white">mdi-account-plus</v-icon>
                {{ $t('employee.frmAddEmp') }}
            </span>
            <span v-else class="white--text khmer-font"
              ><v-icon left dark>mdi-account-edit</v-icon>
                {{ $t('employee.frmEditEmp') }}
              </span
            >
          </v-toolbar>

          <form
            @submit.prevent="editMode ? updateEmployee() : createEmployee()"
            enctype="multipart/form-data"
          >
            <v-card-text>
                <v-row>
                    <v-col sm="8">
                        <v-text-field
                            v-model="form.name"
                            v-bind:label="$t('employee.txtName')"
                            color="cyan darken-1"
                            class="khmer-font"
                            prepend-icon="mdi-account-tie"
                            :error-messages="errorsMessage.name"
                        ></v-text-field>

                        <v-radio-group
                            v-model="form.gender"
                            row
                            :error-messages="errorsMessage.gender"
                            class="p-0 m-0 ml-5 employee-radio"
                        >
                            <v-radio v-bind:label="$t('employee.genderM')" value="male"></v-radio>
                            <v-radio v-bind:label="$t('employee.genderF')" value="female"></v-radio>
                        </v-radio-group>

                        <v-text-field
                            v-model="form.email"
                            v-bind:label="$t('employee.txtEmail')"
                            color="cyan darken-1"
                            class="khmer-font"
                            prepend-icon="mdi-email"
                            :error-messages="errorsMessage.email"
                        ></v-text-field>

                        <!-- ==========POSITION============ -->
                        <v-autocomplete
                            v-model="form.position_id"
                            :items="positionData"
                            :item-text="(item) => item.title"
                            item-value="id"
                            class="khmer-font"
                            clearable
                            v-bind:label="$t('employee.selectPosition')"
                            color="cyan darken-1"
                            prepend-icon="mdi-account-star"
                            :error-messages="errorsMessage.position_id"
                        >
                            <template v-slot:selection="data">
                                <v-chip
                                    label
                                    dark
                                    color="blue-grey darken-2"
                                    class="text-capitalize pa-1 font-weight-regular"
                                    small
                                >
                                    {{ data.item.title }}
                                </v-chip>
                            </template>
                        </v-autocomplete>

                    <!-- ----------- -->
                    <v-menu
                        v-model="absentDateChoose"
                        :close-on-content-click="false"
                        max-width="290"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-text-field
                                v-bind:label="$t('employee.txtStartDate')"
                                color="cyan darken-1"
                                class="khmer-font"
                                :value="computedDateFormattedMomentjs"
                                prepend-icon="mdi-calendar"
                                readonly
                                v-bind="attrs"
                                v-on="on"
                                :error-messages="errorsMessage.start_date"
                            ></v-text-field>
                        </template>
                        <v-date-picker
                            v-model="form.start_date"
                            @input="absentDateChoose = false"
                        ></v-date-picker>
                    </v-menu>

                    <!-- ==================================== -->
                        <v-row>
                            <v-col sm="11">
                            <span
                                v-for="(number, index) in form.phone_number"
                                :key="index"
                            >
                                <v-text-field
                                    v-model="number.phone"
                                    color="cyan darken-1"
                                    class="khmer-font"
                                    v-bind:label="$t('employee.txtPhoneNum')"
                                    prepend-icon="mdi-phone"
                                    v-mask="'###-###-####'"
                                ></v-text-field>
                                <small v-if="index !== 0" class="btn-remove-phoneNum">
                                <v-icon @click="removePhone(index)">mdi-close</v-icon>
                                </small>
                            </span>
                            </v-col>
                            <v-col sm="1">
                            <v-icon class="icon-add-phone" @click="addPhone"
                                >mdi-plus</v-icon
                            >
                            </v-col>
                        </v-row>

                        <!-- ========LEAVE=DATE========== -->
                        <v-alert
                            v-if="editMode == true"
                            color="red lighten-4"
                            dense
                            class="red--text text--darken-2 khmer-font"
                        >
                           <v-checkbox
                                v-model="form.is_inactived"
                                v-bind:label="$t('employee.isInactive')"
                                color="red"
                                class="pa-0 ma-0"
                                hide-details
                            ></v-checkbox>

                            <v-menu
                                v-model="leaveDateChoose"
                                :close-on-content-click="false"
                                max-width="290"
                                v-if="form.is_inactived"
                            >
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                        v-bind:label="$t('employee.leavedDate')"
                                        :value="computedDateFormattedLeaveDate"
                                        prepend-icon="mdi-calendar"
                                        readonly
                                        v-bind="attrs"
                                        v-on="on"
                                        :error-messages="errorsMessage.leave_date"
                                    ></v-text-field>
                                </template>
                                <v-date-picker
                                    v-model="form.leave_date"
                                    @input="leaveDateChoose = false"
                                ></v-date-picker>
                            </v-menu>
                        </v-alert>


                    </v-col>

                    <v-col sm="4">
                        <v-list-item-avatar
                            tile
                            size="150"
                            color="grey lighten-2"
                            height="180"
                            class="rounded-sm khmer-font"
                        >
                            <v-img
                                v-if="preview_profile"
                                :src="preview_profile"
                                class="img-fluid rounded-sm khmer-font"
                            ></v-img>

                            <v-img
                                v-if="
                                    preview_profile_edit &&
                                    preview_profile_edit != 'default.png'
                                "
                                :src="'/employees/' + preview_profile_edit"
                                class="img-fluid rounded-sm khmer-font"
                            ></v-img>
                        </v-list-item-avatar>
                        <v-file-input
                            show-size
                            v-model="form.image"
                            @change="onFileChange"
                            class="khmer-font"
                            prepend-icon="mdi-image-multiple"
                            v-bind:label="$t('employee.empImage')"
                            @click:clear="clearImage()"
                            :error-messages="errorsMessage.image"
                        />
                    </v-col>
                </v-row>
            </v-card-text>

            <v-card-actions class="card-action">
              <v-spacer></v-spacer>
              <v-btn
                small
                color="grey lighten-2"
                class="khmer-font"
                depressed
                @click="closeDialog"
              >
                {{ $t('employee.btnCancel') }}
              </v-btn>
              <v-btn
                small
                depressed
                type="submit"
                :loading="btnSaveLoading"
                class="khawin-background-color khmer-font"
                dark
              >
                {{ $t('employee.btnSave') }}
              </v-btn>
            </v-card-actions>
          </form>
        </v-card>
      </v-dialog>

      <!-- ---------------Snacbar--------------- -->
      <v-snackbar v-model="snackbar" color="indigo lighten-1" dark>
        {{ alertSnackbarMsg }}
        <template v-slot:action="{ attrs }">
          <v-btn dark text v-bind="attrs" @click="snackbar = false" small>
            close
          </v-btn>
        </template>
      </v-snackbar>

      <!-- ----------dialogDelete------------ -->
      <v-dialog v-model="dialogDelete" max-width="330px">
        <v-card>
          <div class="text-center">
            <v-sheet class="px-7 pt-7 pb-4 mx-auto text-center d-inline-block">
              <v-icon class="text-center pb-3" x-large color="red lighten-2"
                >mdi-alert</v-icon
              >
              <div class="grey--text text--darken-3 text-body-2 mb-4">
                Are you sure to delete
                <b class="red--text tex--lighten-2">{{ userNameDelete }}</b> ?
              </div>

              <v-btn
                :disabled="btnLoading"
                class="ma-1"
                depressed
                small
                @click="dialogDelete = false"
              >
                Cancel
              </v-btn>

              <v-btn
                :loading="btnLoading"
                class="ma-1"
                dark
                color="red"
                small
                depressed
                @click="submitDelete"
              >
                Delete
              </v-btn>
            </v-sheet>
          </div>
        </v-card>
      </v-dialog>
    </div>
  </div>
</template>

<script>
import moment from "moment";
export default {
  data() {
    return {
        tab: null,
        editMode: false,
        searchEmployee: "",
        snackbar: false,
        editMode: false,
        tableLoading: true,
        absentDateChoose: false,
        leaveDateChoose: false,
        cardView: false,
    //   -------Table-header-----------------
        // ActiveEmployeeHeaders: [
        //     {
        //     text: "No.",
        //     align: "start",
        //     value: "id",
        //     },
        //     { text: "Name", value: "name" },
        //     { text: "Gender", value: "gender" },
        //     { text: "Email", value: "email" },
        //     { text: "Position", value: "position" },
        //     { text: "Start Date", value: "start_date" },
        //     { text: "Phone", value: "phone_number" },
        //     { text: "Action", sortable: false, align: "center", value: "actions" },
        // ],

        // InactiveEmployeeHeaders: [
        //     { text: "No.", align: "start", value: "id"},
        //     { text: "Name", value: "name" },
        //     { text: "Gender", value: "gender" },
        //     { text: "Email", value: "email" },
        //     { text: "Position", value: "position" },
        //     { text: "Date started/stopped", value: "start_date" },
        //     { text: "Phone", value: "phone_number" },
        //     { text: "Action", sortable: false, align: "center", value: "actions" },
        // ],
      //   -------/Table-header-----------------
        employeeActiveData: [],
        employeeInactiveData: [],
        employeeActiveCount: "",
        employeeInactiveCount: "",
        positionData: [],
        employeeForm: false,
        form: new Form({
            id: "",
            name: "",
            gender: "",
            email: "",
            start_date: "",
            position_id: "",
            phone_number: [{ phone: "" }],
            image: null,
            is_inactived: false,
            leave_date: "",
        }),

        preview_profile: null,
        preview_profile_edit: null,
        btnSaveLoading: false,
        btnLoading: false,
        image_validation: "",
        alertSnackbarMsg: "",
        errorsMessage: "",
        dialogDelete: false,
        userNameDelete: "",
    };
  },
    computed: {
        formTitle() {
            return this.editMode === false ? "Add Employee" : "Edit Employee";
        },
        computedDateFormattedMomentjs() {
            return this.form.start_date
            ? moment(this.form.start_date).format("DD/MM/YYYY")
            : "";
        },

        computedDateFormattedLeaveDate() {
            return this.form.leave_date
            ? moment(this.form.leave_date).format("DD/MM/YYYY")
            : "";
        },

        ActiveEmployeeHeaders(){
            return [
                {
                    text: "#",
                    align: "start",
                    value: "id",
                },
                { text: this.$t('employee.tbName'), value: "name" },
                { text: this.$t('employee.tbGender'), value: "gender" },
                { text: this.$t('employee.tbEmail'), value: "email" },
                { text: this.$t('employee.tbPosition'), value: "position.title" },
                { text: this.$t('employee.tbStartDate'), value: "start_date" },
                { text: this.$t('employee.tbPhoneNum'), value: "phone_number" },
                { text: this.$t('employee.tbEditDelete'), sortable: false, align: "center", value: "actions" },
            ]
        },

        InactiveEmployeeHeaders(){
            return [
                { text: "#", align: "start", value: "id"},
                { text: this.$t('employee.tbName'), value: "name" },
                { text: this.$t('employee.tbGender'), value: "gender" },
                { text: this.$t('employee.tbEmail'), value: "email" },
                { text: this.$t('employee.tbPosition'), value: "position.title" },
                { text: this.$t('employee.tbStartStopDate'), value: "start_date" },
                { text: this.$t('employee.tbPhoneNum'), value: "phone_number" },
                { text: this.$t('employee.tbEditDelete'), sortable: false, align: "center", value: "actions" },
            ]
        },
    },

    mounted() {
        this.ReadEmployeeActive();
        this.ReadEmployeeInactive();
        this.ReadPosition();
        this.activateMultipleDraggableDialogs();
    },

    methods: {
        ReadEmployeeActive() {
            axios
                .get("http://127.0.0.1:8000/api/active-employee", {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("access_token"),
                },
                })
                .then((response) => {
                    this.employeeActiveData = response.data.data;
                    this.employeeActiveCount = response.data.data.length;
                    this.tableLoading = false;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        ReadEmployeeInactive() {
            axios
                .get("http://127.0.0.1:8000/api/inactive-employee", {
                    headers: {
                        Authorization: "Bearer " + localStorage.getItem("access_token"),
                    },
                })
                .then((response) => {
                    this.employeeInactiveData = response.data.data;
                    this.employeeInactiveCount = response.data.data.length;
                    this.tableLoading = false;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        ReadPosition() {
            axios
                .get("http://127.0.0.1:8000/api/read-position", {
                    headers: {
                        Authorization: "Bearer " + localStorage.getItem("access_token"),
                    },
                })
                .then((response) => {
                    this.positionData = response.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },


        listViewChang(){
            this.cardView = this.cardView ? false : true;
        },

        // randomColor() {
        //   let getColor = "#" + ((Math.random() * 0xffffff) << 0).toString(16);
        //   return "" + getColor + "";
        // },

        formatDate(value) {
            return moment(value).format("DD/MM/YYYY");
        },

        addPhone: function () {
            this.form.phone_number.push({ phone: "" });
        },

        removePhone(index) {
            this.form.phone_number.splice(index, 1);
        },

        openDialog() {
            this.employeeForm = true;
        },

        closeDialog() {
            this.editMode = false;
            this.employeeForm = false;
            this.form.role_id = "";
            this.form.name = "";
            this.form.email = "";
            this.form.gender = null;
            this.form.position_id = "";
            this.form.phone_number = [{ phone: "" }];
            this.form.image = null;
            this.form.start_date = "";
            this.preview_profile = null;
            this.preview_profile_edit = null;
            this.form.password = "";
            this.form.password_confirmation = "";
            this.tableLoading = false;
            this.errorsMessage = "";
            this.btnSaveLoading = false;
        },

        addPhone: function () {
            this.form.phone_number.push({ phone: "" });
        },

        removePhone(index) {
            this.form.phone_number.splice(index, 1);
        },
        // -------------image--------------------
        createImage(file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                this.preview_profile = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        onFileChange(file) {
            if (!file) {
                return;
            }
            this.createImage(file);
        },

        clearImage() {
            this.preview_profile = null;
            this.form.image = null;
        },
        // ---------------------------------

        createEmployee() {
            this.btnSaveLoading = true;
            this.tableLoading = true;
            this.form
                .post("api/create-employee", {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("access_token"),
                },
                })
                .then((response) => {
                    this.ReadEmployeeActive();
                    this.ReadEmployeeInactive();
                    this.closeDialog();
                    this.alertSnackbarMsg = response.data.message;
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

        editEmployee(employee) {

            console.log(employee.position)

            this.editMode = true;
            this.form.id = employee.id;
            if (employee.gender == "male") {
                this.form.gender = "male";
            } else if (employee.gender == "female") {
                this.form.gender = "female";
            }
            this.form.name = employee.name;
            this.form.email = employee.email;
            this.form.phone_number = employee.phone_number;
            this.preview_profile_edit = employee.image;
            this.form.position_id = employee.position.id;
            this.form.start_date = employee.start_date;
            this.form.is_inactived = employee.is_inactived;
            this.form.leave_date = employee.leave_date;
            this.employeeForm = true;
        },

        async updateEmployee() {
            this.btnSaveLoading = true;
            this.tableLoading = true;
            await new Promise((resolve) => setTimeout(resolve, 1000));
            this.form
                .post("/api/update-employee/" + this.form.id, {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("access_token"),
                },
                })
                .then((response) => {
                this.ReadEmployeeActive();
                    this.ReadEmployeeInactive();
                    this.closeDialog();
                    this.alertSnackbarMsg = response.data.message;
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

        deleteEployee(user, name) {
            this.form.id = user;
            this.userNameDelete = name;
            this.dialogDelete = true;
        },

        async submitDelete() {
            this.btnLoading = true;
            this.tableLoading = true;
            await new Promise((resolve) => setTimeout(resolve, 1000));
            axios
                .delete("/api/delete-employee/" + this.form.id, {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("access_token"),
                },
                })
                .then((response) => {
                    this.ReadEmployeeActive();
                    this.ReadEmployeeInactive();
                    this.dialogDelete = false;
                    this.alertSnackbarMsg = response.data.message;
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
