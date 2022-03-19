<template>
  <div id="dashboard">
    <h3 class="grey--text text--darken-2 mb-2">
      <v-icon class="mb-1" color="grey darken-2">mdi-view-dashboard</v-icon>
      <span class="text-decoration-underline">Dashboard</span>
    </h3>

    <!-- ===========skeleton=============== -->
    <v-row v-show="skeletonLoading">
      <v-col cols="12" sm="12" md="4">
        <v-card class="dashboard-card" elevation="1">
          <v-card-title class="grey--text text--darken-2">
            <v-skeleton-loader
              type="table-heading"
              width="100%"
            ></v-skeleton-loader>
          </v-card-title>

          <v-card-text>
            <v-row>
              <v-col cols="4" class="text-center">
                <v-icon size="70" color="indigo">mdi-account-multiple</v-icon>
              </v-col>
              <v-col cols="8" class="text-right">
                <v-skeleton-loader
                  type="list-item-two-line"
                  width="50%"
                ></v-skeleton-loader>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>

      <v-col cols="12" sm="12" md="4">
        <v-card class="dashboard-card" elevation="1">
          <v-card-title class="grey--text text--darken-2">
            <v-skeleton-loader
              type="table-heading"
              width="100%"
            ></v-skeleton-loader>
          </v-card-title>

          <v-card-text>
            <v-row>
              <v-col cols="4" class="text-center">
                <v-icon size="70" color="teal">mdi-account-tie</v-icon>
              </v-col>
              <v-col cols="8" class="text-right">
                <v-skeleton-loader
                  type="list-item-two-line"
                  width="50%"
                ></v-skeleton-loader>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>

      <v-col cols="12" sm="12" md="4">
        <v-card class="dashboard-card" elevation="1">
          <v-card-title class="grey--text text--darken-2">
            <v-skeleton-loader
              type="table-heading"
              width="100%"
            ></v-skeleton-loader>
          </v-card-title>

          <v-card-text>
            <v-row>
              <v-col cols="4" class="text-center">
                <v-icon size="70" color="orange darken-3"
                  >mdi-account-cancel</v-icon
                >
              </v-col>
              <v-col cols="8" class="text-right">
                <v-skeleton-loader
                  type="list-item-three-line"
                  width="50%"
                ></v-skeleton-loader>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <!-- ===========/skeleton=============== -->

    <!-- ================Card=============== -->
    <v-row v-show="!skeletonLoading">
      <!-- Users -->
      <v-col cols="12" sm="12" md="4">
        <v-card class="dashboard-card" elevation="1">
          <v-card-title class="grey--text text--darken-2">
            <h4 class="indigo--text">USERS</h4>
            <v-spacer></v-spacer>
            <h2 v-if="user.all < 10" class="indigo--text">0{{ user.all }}</h2>
            <h2 v-else class="indigo--text">{{ user.all }}</h2>
          </v-card-title>

          <v-card-text>
            <v-row>
              <v-col cols="4" class="text-center">
                <v-icon size="70" color="indigo">mdi-account-multiple</v-icon>
              </v-col>
              <v-col cols="8" class="text-right">
                <h3 v-if="user.admin < 10">Admin : 0{{ user.admin }}</h3>
                <h3 v-else>Admin : {{ user.admin }}</h3>
                <h3 v-if="user.user < 10">User : 0{{ user.user }}</h3>
                <h3 v-else>User : {{ user.user }}</h3>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>

      <!-- Employee -->
      <v-col cols="12" sm="12" md="4">
        <v-card class="dashboard-card" elevation="1">
          <v-card-title class="grey--text text--darken-2">
            <h4 class="teal--text">EMPLOYEES</h4>
            <v-spacer></v-spacer>
            <h2 class="teal--text" v-if="employee.all < 10">
              0{{ employee.all }}
            </h2>
            <h2 class="teal--text" v-else>
              {{ employee.all }}
            </h2>
          </v-card-title>

          <v-card-text>
            <v-row>
              <v-col cols="4" class="text-center">
                <v-icon size="70" color="teal">mdi-account-tie</v-icon>
              </v-col>
              <v-col cols="8" class="text-right">
                <h3 v-if="employee.senior < 10">
                  Senior : 0{{ employee.senior }}
                </h3>
                <h3 v-else>Senior : {{ employee.senior }}</h3>
                <h3 v-if="employee.junior < 10">
                  Junior : 0{{ employee.junior }}
                </h3>
                <h3 v-else>Junior : {{ employee.junior }}</h3>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>

      <!-- Absent -->
      <v-col cols="12" sm="12" md="4">
        <v-card class="dashboard-card" elevation="1">
          <v-card-title class="grey--text text--darken-2">
            <h4 class="orange--text text--darken-3">ABSENTS</h4>
            <v-spacer></v-spacer>
            <h2 class="orange--text text--darken-3">
              <span v-if="absent.all > 10">{{ absent.all }}</span>
              <span v-else> 0{{ absent.all }}</span>
            </h2>
          </v-card-title>

          <v-card-text>
            <v-row>
              <v-col cols="4" class="text-center">
                <v-icon size="70" color="orange darken-3"
                  >mdi-account-cancel</v-icon
                >
              </v-col>
              <v-col cols="8" class="text-right">
                <h3 v-if="absent.weekCount < 10">
                  this Week : 0{{ absent.weekCount }}
                </h3>
                <h3 v-else>this Week : {{ absent.weekCount }}</h3>

                <h3 v-if="absent.monthly < 10">
                  this Month : 0{{ absent.monthly }}
                </h3>
                <h3 v-else>this Month : {{ absent.monthly }}</h3>

                <h3 v-if="absent.year < 10">this Year : 0{{ absent.year }}</h3>
                <h3 v-else>this Year : {{ absent.year }}</h3>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <!-- ================Table================= -->
    <v-card class="mt-5">
      <v-card-title>
        <h5 class="grey--text text--darken-2 font-weight-medium">
          <v-icon>mdi-account-cancel</v-icon> Absence Summary
        </h5>
      </v-card-title>
      <v-card-text>
        <v-row>
          <!-- ---weekly--- -->
          <v-col cols="12" sm="12" md="4">
            <v-card class="mx-auto" outlined>
              <div class="ma-2">
                <v-icon small>mdi-table-account</v-icon> this Week
              </div>
              <v-data-table
                :headers="headers"
                :items="table.weeklyAbsent"
                loading-text="Loading Report data"
                dense
                :items-per-page="-1"
                :expanded.sync="expandedWeekly"
                show-expand
                hide-default-footer
                fixed-header
              >
                <template v-slot:expanded-item="{ headers, item }">
                  <td :colspan="headers.length" class="pa-1">
                    <v-simple-table dense>
                      <template v-slot:default>
                        <tbody>
                          <tr
                            v-for="(data, index) in item.absents"
                            :key="index"
                          >
                            <td>
                              <h5 class="grey--text text--darken-2">
                                {{ index + 1 }}
                              </h5>
                            </td>
                            <td>
                              <span
                                v-if="data.absent == 'fullday'"
                                class="deep-orange--text"
                                >full day</span
                              >
                              <span v-else class="blue-grey--text"
                                >half day</span
                              >
                            </td>
                            <td class="text-lowercase">
                              {{ data.day }}
                            </td>
                            <td>
                              {{ formatDate(data.date) }}
                            </td>
                            <td>{{ data.description }}</td>
                          </tr>
                        </tbody>
                      </template>
                    </v-simple-table>
                  </td>
                </template>

                <template v-slot:[`item.name`]="item">
                  <v-avatar
                    size="23"
                    class="ma-1 white--text"
                    left
                    v-if="item.item.pic == 'default.png'"
                    :color="'#' + item.item.profile_color"
                  >
                    {{
                      item.item.name
                        .split(" ")
                        .map((x) => x[0].toUpperCase())
                        .join("")
                    }}
                  </v-avatar>

                  <v-avatar size="22" class="ma-1" left v-else>
                    <v-img :src="'/employees/' + item.item.pic" />
                  </v-avatar>
                  <span>{{ item.item.name }}</span>
                </template>

                <template v-slot:[`item.absent_total`]="item">
                  <v-chip
                    class="pa-2 count_chip font-weight-medium"
                    small
                    outlined
                  >
                    <span class="font-weight-medium orange--text text--darken-3"
                      >{{ item.item.absent_total }} day</span
                    >
                  </v-chip>
                </template>
              </v-data-table>
            </v-card>
          </v-col>

          <!-- --Monthly-- -->
          <v-col cols="12" sm="12" md="4">
            <v-card class="mx-auto" outlined>
              <div class="ma-2">
                <v-icon small>mdi-table-account</v-icon> this Month
              </div>
              <v-data-table
                :headers="headers"
                :items="table.monthlyAbsent"
                loading-text="Loading Report data"
                dense
                :items-per-page="-1"
                :expanded.sync="expandedMonthly"
                show-expand
                hide-default-footer
                fixed-header
              >
                <template v-slot:expanded-item="{ headers, item }">
                  <td :colspan="headers.length" class="pa-1">
                    <v-simple-table dense>
                      <template v-slot:default>
                        <tbody>
                          <tr
                            v-for="(data, index) in item.absents"
                            :key="index"
                          >
                            <td>
                              <h5 class="grey--text text--darken-2">
                                {{ index + 1 }}
                              </h5>
                            </td>
                            <td>
                              <span
                                v-if="data.absent == 'fullday'"
                                class="deep-orange--text"
                                >full day</span
                              >
                              <span v-else class="blue-grey--text"
                                >half day</span
                              >
                            </td>
                            <td class="text-lowercase">
                              {{ data.day }}
                            </td>
                            <td>
                              {{ formatDate(data.date) }}
                            </td>
                            <td>{{ data.description }}</td>
                          </tr>
                        </tbody>
                      </template>
                    </v-simple-table>
                  </td>
                </template>

                <template v-slot:[`item.name`]="item">
                  <v-avatar
                    size="23"
                    class="ma-1 white--text"
                    left
                    v-if="item.item.pic == 'default.png'"
                    :color="'#' + item.item.profile_color"
                  >
                    {{
                      item.item.name
                        .split(" ")
                        .map((x) => x[0].toUpperCase())
                        .join("")
                    }}
                  </v-avatar>

                  <v-avatar size="22" class="ma-1" left v-else>
                    <v-img :src="'/employees/' + item.item.pic" />
                  </v-avatar>
                  <span>{{ item.item.name }}</span>
                </template>

                <template v-slot:[`item.absent_total`]="item">
                  <v-chip
                    class="pa-2 count_chip font-weight-medium"
                    small
                    outlined
                  >
                    <span class="font-weight-medium orange--text text--darken-3"
                      >{{ item.item.absent_total }} day</span
                    >
                  </v-chip>
                </template>
              </v-data-table>
            </v-card>
          </v-col>

          <!-- ----Yearly------ -->
          <v-col cols="12" sm="12" md="4">
            <v-card class="mx-auto" outlined>
              <div class="ma-2">
                <v-icon left small>mdi-table-account</v-icon> this Year
              </div>
              <v-data-table
                :headers="headers"
                :items="table.yearlyAbsent"
                loading-text="Loading Report data"
                dense
                :items-per-page="-1"
                :expanded.sync="expandedYearly"
                show-expand
                hide-default-footer
                fixed-header
              >
                <template v-slot:expanded-item="{ headers, item }">
                  <td :colspan="headers.length" class="pa-1">
                    <v-simple-table dense>
                      <template v-slot:default>
                        <tbody>
                          <tr
                            v-for="(data, index) in item.absents"
                            :key="index"
                          >
                            <td>
                              <h5 class="grey--text text--darken-2">
                                {{ index + 1 }}
                              </h5>
                            </td>
                            <td>
                              <span
                                v-if="data.absent == 'fullday'"
                                class="deep-orange--text"
                                >full day</span
                              >
                              <span v-else class="blue-grey--text"
                                >half day</span
                              >
                            </td>
                            <td class="text-lowercase">
                              {{ data.day }}
                            </td>
                            <td>
                              {{ formatDate(data.date) }}
                            </td>
                            <td>{{ data.description }}</td>
                          </tr>
                        </tbody>
                      </template>
                    </v-simple-table>
                  </td>
                </template>

                <template v-slot:[`item.name`]="item">
                  <v-avatar
                    size="23"
                    class="ma-1 white--text"
                    left
                    v-if="item.item.pic == 'default.png'"
                    :color="'#' + item.item.profile_color"
                  >
                    {{
                      item.item.name
                        .split(" ")
                        .map((x) => x[0].toUpperCase())
                        .join("")
                    }}
                  </v-avatar>

                  <v-avatar size="22" class="ma-1" left v-else>
                    <v-img :src="'/employees/' + item.item.pic" />
                  </v-avatar>
                  <span>{{ item.item.name }}</span>
                </template>

                <template v-slot:[`item.absent_total`]="item">
                  <v-chip
                    class="pa-2 count_chip font-weight-medium"
                    small
                    outlined
                  >
                    <span class="font-weight-medium orange--text text--darken-3"
                      >{{ item.item.absent_total }} day</span
                    >
                  </v-chip>
                </template>
              </v-data-table>
            </v-card>
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
import moment from "moment";
export default {
  data() {
    return {
      expandedWeekly: [],
      expandedMonthly: [],
      expandedYearly: [],
      skeletonLoading: false,
      headers: [
        { text: "Employee", value: "name", align: "start" },
        // { text: "Count", value: "absent_count" },
        { text: "Total", value: "absent_total" },
      ],
      weeklyAbsentData: [],
      monthlyAbsentData: [],
      absent: {
        all: "",
        weekCount: "",
        monthly: "",
        year: "",
      },
      employee: {
        all: "",
        senior: "",
        junior: "",
      },
      user: {
        all: "",
        admin: "",
        user: "",
      },
      table: {
        weeklyAbsent: [],
        monthlyAbsent: [],
        yearlyAbsent: [],
      },
    };
  },
  mounted() {
    this.getReport();
  },

  methods: {
    formatDate(value) {
      return moment(value).format("DD-MM-YYYY");
    },

    getReport() {
      axios
        .get("/api/dashboard-data/", {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token"),
          },
        })
        .then((response) => {
          console.log(response.data.absent.weeklyAbsents);

          // ----------absent---------
          this.absent.all = response.data.absent.absentCount;
          this.absent.weekCount = response.data.absent.absentWeekCount;
          this.absent.monthly = response.data.absent.absentMonthCount;
          this.absent.year = response.data.absent.absentYearCount;

          // ----------employee---------
          this.employee.all = response.data.employee.allEmployee;
          this.employee.senior = response.data.employee.senior;
          this.employee.junior = response.data.employee.junior;

          // ----------User-------------
          this.user.all = response.data.user.allUser;
          this.user.admin = response.data.user.admin;
          this.user.user = response.data.user.user;

          // ---------Table-------------
          this.table.weeklyAbsent = response.data.absent.weeklyAbsents;
          this.table.monthlyAbsent = response.data.absent.monthlyAbsents;
          this.table.yearlyAbsent = response.data.absent.yearAbsents;
        })
        .catch((errors) => {
          console.log(errors);
        });
    },
  },
};
</script>
