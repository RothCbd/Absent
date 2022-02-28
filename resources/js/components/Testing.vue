<template>
  <v-app>
    <div class="card" id="invoice">
      <div class="header">
        <h2>
          <img
            src="/icon/leftmenu/invoice.svg"
            width="20px"
            height="20px"
            alt=""
          />
          All Unpaid Invoice <span class="badge bg-purple">{{ count }}</span>
        </h2>
      </div>
      <div class="body">
        <div class="table-responsive">
          <v-skeleton-loader
            v-if="firstLoad"
            :loading="loading"
            type="table"
          ></v-skeleton-loader>
          <v-row class="mb-2">
            <v-col md="2" offset-md="10">
              <v-text-field
                v-model="search"
                v-show="!firstLoad"
                :loading="loading"
                append-icon="mdi-magnify"
                label="Search"
                single-line
                hide-details
              ></v-text-field>
            </v-col>
          </v-row>
          <v-data-table
            dense
            :headers="headers"
            :items="invoices"
            :search="search"
            group-by="building.name"
            :loading="loading"
            v-show="!firstLoad"
          >
            <template
              v-slot:[`group.header`]="{
                group,
                headers,
                toggle,
                isOpen,
                items,
              }"
            >
              <td :colspan="headers.length" class="group-header">
                <v-btn
                  @click="toggle"
                  small
                  icon
                  :ref="group"
                  :data-open="isOpen"
                >
                  <v-icon v-if="isOpen">mdi-chevron-up</v-icon>
                  <v-icon v-else>mdi-chevron-down</v-icon>
                </v-btn>
                <v-chip color="indigo" text-color="white">
                  {{ group }}
                  <v-avatar right class="indigo darken-4">{{
                    items.length
                  }}</v-avatar>
                </v-chip>
              </td>
            </template>

            <template v-slot:[`item.invoice_number`]="{ item }">
              <v-chip class="blue--text text--darken-4 font-weight-bold">
                {{ item.invoice_number }}
              </v-chip>
            </template>

            <template v-slot:[`item.unit_name.name`]="{ item }">
              <v-chip text-color="black">
                {{ item.unit_number.number }}
              </v-chip>
              <span class="text-capitalize">{{ item.unit_name.name }}</span>
            </template>

            <template v-slot:[`item.customer.name`]="{ item }">
              {{ item.customer.name }}
            </template>

            <template v-slot:[`item.renttype.type`]="{ item }">
              <v-chip :color="getStatus(item.renttype.type)">
                {{ item.renttype.type | capitalize }}
              </v-chip>
            </template>

            <template v-slot:[`item.building.name`]="{ item }">
              <v-chip label color="green" text-color="white">
                {{ item.building.name }}
              </v-chip>
            </template>

            <template v-slot:[`item.status`]="{ item }">
              <v-chip xm color="pink" label text-color="white">
                {{ item.status }}
              </v-chip>
            </template>

            <template v-slot:[`item.date_created`]="{ item }">
              <v-chip color="primary" label text-color="white">
                {{ formatDate(item.date_created) }}
              </v-chip>
            </template>

            <template v-slot:[`item.actions`]="{ item }">
              <v-icon small class="mr-2 blue--text" @click="viewInvoice(item)"
                >mdi-printer</v-icon
              >
            </template>
          </v-data-table>
        </div>
      </div>
    </div>
    <!-- =========================Dailog=Invoice============================== -->

    <v-row justify="center">
      <v-dialog
        v-model="dialog"
        fullscreen
        hide-overlay
        transition="dialog-bottom-transition"
      >
        <v-card flat>
          <v-toolbar color="primary" dark extended flat>
            <v-btn icon dark @click="dialog = false">
              <v-icon>mdi-arrow-left</v-icon> back
            </v-btn>
          </v-toolbar>

          <v-card class="mx-auto" max-width="800" style="margin-top: -54px">
            <v-toolbar flat class="invoice-page-header">
              <v-toolbar-title class="grey--text text--darken-2">
                <h4 class="font-weight-medium">
                  Invoice for {{ iv_buildingname }} - Room
                  <v-chip small color="primary" text-color="white">{{
                    iv_unitnumber
                  }}</v-chip>
                </h4>
              </v-toolbar-title>
              <v-spacer></v-spacer>
              <v-btn
                depressed
                small
                dark
                color="primary"
                @click="PaymentDialog = true"
                >payment <v-icon>mdi-credit-card-outline </v-icon></v-btn
              >
              <v-btn
                depressed
                color="blue-grey"
                class="ma-2 white--text"
                small
                @click="saveInvoicePrint"
                >print <v-icon>mdi-printer</v-icon></v-btn
              >
            </v-toolbar>
            <v-divider></v-divider>

            <v-skeleton-loader
              v-if="invoicefirstLoad"
              :loading="invoiceloading"
              type="article, list-item-two-line"
            ></v-skeleton-loader>
            <v-card-text
              v-show="!invoicefirstLoad"
              :loading="invoiceloading"
              id="invoice-page"
              class="grey--text text--darken-4"
            >
              <h1>INVOICE</h1>
              <div class="mt-3 building-info">
                <h6 class="text-capitalize">
                  Building Name: {{ iv_buildingname }}
                </h6>
                <h6>Unit Number: {{ iv_unitnumber }}</h6>
                <h6 class="text-capitalize">Unit Name: {{ iv_unitname }}</h6>
              </div>
              <div class="row mt-5">
                <div class="col-8 iv-customerInfo">
                  <h4>BILL TO</h4>
                  <h6>Customer Name: {{ iv_customername }}</h6>
                  <h6 class="text-capitalize">Gender: {{ iv_cus_gender }}</h6>
                  <h6>
                    Phone Number: {{ iv_cus_phone1 }}
                    <span v-if="iv_cus_phone2">,{{ iv_cus_phone2 }}</span>
                  </h6>
                  <h6>Rent Type : {{ in_renttype }}</h6>
                </div>
                <div
                  class="col-2"
                  style="
                    display: flex;
                    justify-content: center;
                    align-items: center;
                  "
                >
                  <div>
                    <h5>INVOICE</h5>
                    <h6>INVOICE DATE :</h6>
                    <h6>USER :</h6>
                    <h6>STATUS :</h6>
                  </div>
                </div>
                <div
                  class="col-2"
                  style="display: flex; align-items: center; color: #192a56"
                >
                  <div>
                    <h5>{{ iv_number }}</h5>
                    <h6>{{ formatDate(iv_date_created) }}</h6>
                    <h6>{{ user }}</h6>
                    <h6>
                      <span class="text-danger red--text">{{ in_status }}</span>
                    </h6>
                  </div>
                </div>
              </div>
              <table class="table mt-5">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Item</th>
                    <th scope="col">Price/Unite</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Total</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in invoiceItems" :key="item.message">
                    <th>{{ index + 1 }}</th>
                    <td data-label="Item">
                      <input
                        class="blue-grey lighten-5"
                        type="text"
                        v-model="item.description"
                      />
                    </td>
                    <td>
                      <div class="cell-with-input">
                        $
                        <input
                          class="blue-grey lighten-5"
                          type="number"
                          min="0"
                          v-model="item.price"
                        />
                      </div>
                    </td>
                    <td data-label="Quantity">
                      <input
                        class="blue-grey lighten-5"
                        type="number"
                        min="0"
                        v-model="item.quantity"
                      />
                    </td>
                    <th>{{ decimalDigits(item.price * item.quantity) }}</th>
                    <td class="text-right">
                      <v-icon
                        class="pink--text"
                        v-if="index > 0"
                        v-on:click="deleteItem(index)"
                        id="removeitem"
                        >mdi-close-circle</v-icon
                      >
                    </td>
                  </tr>
                </tbody>
              </table>
              <div class="row">
                <div class="col-8">
                  <v-btn
                    small
                    color="primary"
                    id="additem"
                    v-on:click="addNewItem"
                    >Add item</v-btn
                  >
                </div>
                <div class="col-4 invoice-result mb-10">
                  <table>
                    <tr>
                      <td>Subtotal</td>
                      <td>{{ decimalDigits(subTotal) }}</td>
                    </tr>
                    <tr>
                      <td>
                        <div class="cell-with-input">
                          Discount
                          <input
                            class="text-right"
                            type="number"
                            min="0"
                            max="100"
                            v-model="discountRate"
                          />%
                        </div>
                      </td>
                      <td class="text-right">
                        {{ decimalDigits(discountTotal) }}
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="cell-with-input">
                          Tax
                          <input
                            class="text-right"
                            type="number"
                            min="0"
                            max="100"
                            v-model="taxRate"
                          />%
                        </div>
                      </td>
                      <td class="text-right">{{ decimalDigits(taxTotal) }}</td>
                    </tr>
                    <tr class="text-bold">
                      <td><h5>Grand Total</h5></td>
                      <td>
                        <h5>{{ decimalDigits(grandTotal) }}</h5>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </v-card-text>
          </v-card>
        </v-card>
      </v-dialog>
    </v-row>

    <!-- =========================Dailog=Payment=============================== -->

    <v-dialog v-model="PaymentDialog" width="500" persistent>
      <form @submit.prevent="submitpayment()">
        <v-card>
          <input type="number" v-model="form.id" hidden />
          <v-progress-linear
            :active="submitloading"
            :indeterminate="submitloading"
            absolute
            top
            color="white accent-4"
          ></v-progress-linear>
          <v-card-title class="headline primary"
            ><span class="ml-3 white--text"
              ><h4 class="white--text">
                Payment Invoice {{ iv_number }}
              </h4></span
            ></v-card-title
          >
          <has-error :form="form" field="total_amount"></has-error>
          <v-card-text>
            <h4 class="mt-5">Total Amount : {{ decimalDigits(grandTotal) }}</h4>
            <v-text-field
              class="mt-5 font-weight-medium"
              outlined
              label="Input-Amount"
              :rules="amountRules"
              v-mask="'#####'"
              v-model="form.total_amount"
              prefix="$"
            ></v-text-field>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              small
              depressed
              color="primary"
              type="submit"
              :disabled="checkAmount"
              >submit
              <v-icon class="ml-1">mdi-credit-card-outline </v-icon></v-btn
            >
            <v-btn small depressed @click="PaymentDialog = false">cancel</v-btn>
          </v-card-actions>
        </v-card>
      </form>
    </v-dialog>
    <!-- --------Print-dialog-wait------------ -->
    <v-dialog v-model="printDialog" hide-overlay width="300">
      <v-card color="primary" dark id="printDailog">
        <v-card-text>
          Please Wait
          <v-progress-linear indeterminate color="white"></v-progress-linear>
        </v-card-text>
      </v-card>
    </v-dialog>
    <!-- ----------------- -->
    <vue-progress-bar></vue-progress-bar>
    <vue-snotify></vue-snotify>
  </v-app>
</template>


<script>
import moment from "moment";
export default {
  data() {
    return {
      dialog: false,
      PaymentDialog: false,
      submitloading: false,
      search: "",
      loading: true,
      firstLoad: true,

      printDialog: false,

      invoices: [],
      headers: [
        {
          align: "start",
        },
        { text: "Invoice Number", value: "invoice_number" },
        { text: "Unit", value: "unit_name.name" },
        { text: "Price($)", value: "unit_price.price" },
        { text: "Customer", value: "customer.name" },
        { text: "Rent_Type", value: "renttype.type" },
        { text: "Building", value: "building.name" },
        { text: "Status", value: "status" },
        { text: "Created", value: "date_created" },
        { text: "Actions", value: "actions", sortable: false },
      ],
      count: "",
      // ------------invoice-------------
      form: new Form({
        id: "",
        total_amount: "",
      }),
      invoiceCurrency: {
        symbol: "$",
        name: "US Dollar",
        symbol_native: "$",
        decimal_digits: 2,
        rounding: 0,
        code: "USD",
        name_plural: "US dollars",
      },
      invoiceItems: [],
      taxRate: 0,
      discountRate: 0,
      // ----amount-------
      amountRules: [
        (value) => !!value || "Required.",
        (value) =>
          parseFloat(this.grandTotal) <= parseFloat(value) ||
          "Amount not Balance with Total Amount",
      ],

      invoiceloading: true,
      invoicefirstLoad: true,
      user: "",
      iv_number: "",
      iv_customername: "",
      iv_buildingname: "",
      iv_unitname: "",
      iv_unitnumber: "",
      iv_cus_gender: "",
      iv_cus_phone1: "",
      iv_cus_phone2: "",
      iv_date_created: "",
      iv_invoice_due_date: "",
      in_status: "",
      in_renttype: "",
      iv_unitprice: "",
    };
  },
  computed: {
    subTotal: function () {
      var total = this.invoiceItems.reduce(function (accumulator, item) {
        return accumulator + item.price * item.quantity;
      }, 0);
      return total;
    },
    discountTotal: function () {
      var total = this.subTotal * (this.discountRate / 100);
      return total;
    },
    taxTotal: function () {
      var total = (this.subTotal - this.discountTotal) * (this.taxRate / 100);
      return total;
    },
    grandTotal: function () {
      var total = this.subTotal - this.discountTotal + this.taxTotal;
      return total;
    },
    checkAmount: function () {
      return this.form.total_amount >= this.grandTotal ? false : true;
    },
  },
  mounted() {
    $(".modal").draggable({
      handle: ".card .header",
    });
    this.generate_invoice();
  },
  filters: {
    capitalize: function (value) {
      if (!value) return "";
      value = value.toString();
      return value.charAt(0).toUpperCase() + value.slice(1);
    },
  },
  methods: {
    getInvoiceData() {
      this.$Progress.start();
      axios
        .get("/api/invoice")
        .then((response) => {
          this.invoices = response.data.data;
          this.count = response.data.data.length;
          this.$Progress.finish();
        })
        .catch((e) => {
          console.log(e);
          this.$Progress.fail();
        });
    },
    formatDate(value) {
      return moment(value).format("DD-MM-YYYY");
    },
    getStatus(type_renting) {
      if (type_renting === "daily" || type_renting === "Daily") {
        return "cyan";
      } else if (type_renting === "weekly" || type_renting === "weekly") {
        return "teal darken-1";
      } else if (type_renting === "monthly" || type_renting === "Monthly") {
        return "purple";
      } else {
        return "teal darken-1";
      }
    },
    generate_invoice() {
      this.loading = true;
      axios
        .get("api/generate_invoice/")
        .then((response) => {
          this.getInvoiceData();

          setTimeout(() => {
            if (this.firstLoad) this.firstLoad = false;
            this.loading = false;
          }, 100);
        })
        .catch((e) => {
          console.log(e);
        });
    },
    viewInvoice(item) {
      this.invoiceItems = [];
      this.invoiceloading = true;
      this.invoicefirstLoad = true;
      this.dialog = true;

      this.iv_customername = item.customer.name;
      this.iv_buildingname = item.building.name;
      this.iv_unitnumber = item.unit_number.number;
      this.iv_unitname = item.unit_name.name;
      this.iv_unitprice = item.unit_price.price;
      axios
        .get("api/invoice_detail/" + item.id)
        .then((response) => {
          // ------------invoice-items-----------
          if (response.data.invoice.data[0].invoice_items != null) {
            this.invoiceItems = response.data.invoice.data[0].invoice_items;
          } else {
            this.invoiceItems.push({
              description: item.unit_name.name,
              quantity: 1,
              price: item.unit_price.price,
            });
          }
          // -----------/-invoice-items-----------

          this.form.id = response.data.invoice.data[0].id;
          this.iv_number = response.data.invoice.data[0].invoice_number;
          this.iv_cus_gender = response.data.invoice.data[0].customer.gender;
          this.iv_cus_phone1 = response.data.invoice.data[0].customer.phone1;
          this.iv_cus_phone2 = response.data.invoice.data[0].customer.phone2;
          this.iv_date_created = response.data.invoice.data[0].date_created;
          this.in_status = response.data.invoice.data[0].status;
          this.in_renttype = response.data.invoice.data[0].renttype.type;
          this.user = response.data.user;
          setTimeout(() => {
            if (this.invoicefirstLoad) this.invoicefirstLoad = false;
            this.invoiceloading = false;
          }, 300);
        })
        .catch((e) => {
          console.log(e);
        });
    },
    addNewItem: function () {
      this.invoiceItems.push({
        description: "Item name",
        quantity: 0,
        price: 0,
      });
    },
    deleteItem: function (index) {
      this.invoiceItems.splice(index, 1);
    },
    decimalDigits: function (value) {
      return (
        this.invoiceCurrency.symbol +
        " " +
        value.toFixed(this.invoiceCurrency.decimal_digits)
      );
    },
    submitpayment() {
      // ---------------------save-invoice-befor-submit------------------
      axios
        .post("api/save-invoice/", {
          invoiceItems: this.invoiceItems,
          id: this.form.id,
        })
        .then((response) => {})
        .catch((e) => {
          console.log(e);
        });
      // --------------------/-save-invoice-befor-submit--------------------

      this.submitloading = true;
      this.form
        .post("/api/invoice-paid")
        .then((response) => {
          if (this.form.successful) {
            setTimeout(
              () => this.$router.push({ path: "/invoice-paid" }),
              2000
            );
          } else {
            this.$snotify.error("Something went wrong!", "Error");
          }
        })
        .catch((e) => {
          this.$Progress.fail();
          console.log(e);
        });
    },

    saveInvoicePrint: function (e) {
      axios
        .post("api/save-invoice/", {
          invoiceItems: this.invoiceItems,
          id: this.form.id,
        })
        .then((response) => {
          this.printDialog = true;
          setTimeout(() => (window.print(), (this.printDialog = false)), 1000);
        })
        .catch((e) => {
          console.log(e);
        });
    },
  },
};
</script>

<style scoped>
#invoice-page h1,
h5,
h4,
h6,
span {
  color: #192a56 !important;
}
#invoice-page h6 {
  margin-top: -3px;
}
.invoice-result tr {
  border-bottom: 1px solid rgba(243, 135, 33, 0.507);
  font-size: 15px;
  height: 30px;
}
.v-card__title {
  height: 50px;
}
.building-info h5 {
  margin-top: -5px;
}
.iv-customerInfo h6 {
  margin-top: -5px !important;
}
@media print {
  #leftsidebar {
    display: none;
  }
  .navbar {
    display: none;
  }
  #invoice {
    display: none;
  }
  .table-responsive {
    display: none;
  }
  .invoice-page-header {
    display: none;
  }
  header {
    display: none;
  }
  #invoice-page h1,
  h5,
  h4,
  h6,
  span {
    color: #192a56 !important;
  }
  #removeitem {
    display: none;
  }
  .building-info h5 {
    margin-top: -5px;
  }
  #additem {
    display: none;
  }
  input[type="number"] {
    -moz-appearance: textfield;
  }
  #printDailog {
    display: none;
  }
}
</style>
