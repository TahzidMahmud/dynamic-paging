/* eslint-disable no-unused-vars */
/* eslint-disable vue/attribute-hyphenation */

<template>
    <div class="row gutters-5">
        <div class="col-md">
            <div class="row gutters-5 mb-3">
                <div class="col-md-6 mb-2 mb-md-0 mt-1 pt-2">
                    <div class="form-group mb-0 mt-1">
                        <input v-model="keyword" class="form-control form-control-lg"  type="text" name="keyword" placeholder="Search by Product Name/Barcode" @keyup="filterProducts">
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <label for="">Select A Category</label>
                    <VSelect
                        v-model="category"
                        :options="cats"
                        :searchable="srcable"
                        add-class="form-control"
                    />
                </div>
                <div class="col-md-3 col-6">
                    <label for="">Select A Brand</label>
                    <VSelect
                        v-model="brand"
                        :options="brand_arr"
                        :searchable="srcable"
                        add-class="form-control"
                    />
                </div>
            </div>
            <div class="aiz-pos-product-list c-scrollbar-light">
                <div class="d-flex flex-wrap justify-content-center">
                    <!-- product card  -->
                    <div v-for="product in products" :key="product.index" class="w-140px w-xl-180px w-xxl-210px mx-2">
                        <div class="card bg-white c-pointer product-card hov-container">
                            <div class="position-relative">
                                <span class="absolute-top-left mt-1 ml-1 mr-0">

                                    <span v-if="product.stock_qty > 0" class="badge badge-inline badge-success fs-13">In stock
                                        : {{ product.stock_qty }}
                                    </span>
                                    <span v-else class="badge badge-inline badge-danger fs-13">Out of stock
                                        :   {{ product.stock_qty }}
                                    </span>

                                </span>
                            </div>
                            <div class="card-body p-2 p-xl-3">
                                <span  v-if="product.variant_name !=''" class="badge badge-inline badge-warning absolute-bottom-right mb-1 ml-1 mr-0 fs-13 text-truncate">{{product.variant_name}}</span>

                                <img :src="product.thumbnail_image" class="card-img-top img-fit h-120px h-xl-180px h-xxl-210px mw-100 mx-auto" >

                                <div class="text-truncate fw-600 fs-14 mb-2">{{product.name}}</div>
                                <div class="">

                                    <span>{{ product.price }}{{currency}}</span>

                                </div>
                            </div>
                            <div v-if="product.stock_qty > 0" class="add-plus absolute-full rounded overflow-hidden hov-box c-not-allowed" data-stock-id=""  @click="addToCart(product.stock_id)">
                                <div class="absolute-full bg-dark opacity-50">
                                </div>
                                <i class="las la-plus absolute-center la-6x text-white"></i>
                            </div>
                            <div v-else>

                            </div>
                        </div>
                    </div>
                </div>
                <div id="load-more" class="text-center">
                    <div class="fs-14 d-inline-block fw-600 btn btn-soft-primary c-pointer" @click="loadMoreProduct">Load More</div>
                </div>
            </div>
        </div>
        <div class="col-md-auto w-md-350px w-lg-400px w-xl-500px">
            <div class="card mb-3">
                <div class="card-body">
                    <div id="addrs">
                        <div class="form-group mb-0 mt-1">
                            <input v-model="customer_q" class="form-control form-control-lg"  type="text" name="customer_q" placeholder="Search Customer by Name/Phone" @keyup="filterCustomer()">
                        </div>
                        <div class="d-flex  pb-3">
                            <div class="flex-grow-1">
                                <label for="">Select A Customer</label>
                                <select  v-model="customer" class="form-control">
                                    <option value="">-- Select One --</option>
                                    <option v-for="cus in customer_arr" :key="cus.index" :value="cus.id">
                                        {{ cus.name }}
                                    </option>
                                </select>
                            </div>
                            <div  class="d-flex flex-column justify-content-center align-items-center">
                                <label for=""><small>add New</small></label>
                                <button i type="button" class="btn btn-icon btn-soft-dark ml-3 mr-0 p-0" onclick="add_new_address()">
                                    <i class="las la-address-book"></i>
                                </button>
                            </div>
                            <button id='addr' ref="addressBtn" type="button" class="" data-target="#new-customer" style="height:0px;width:0px;display:none;" data-toggle="modal" >
                            </button>
                        </div>
                        <div class="d-flex border-bottom pb-3">
                            <div>
                                <div class="flex-grow-1">
                                    <label for="">Select Payment
                                        status
                                    </label>
                                    <select  v-model="pay_status" class="form-control">
                                        <option value="paid">Paid</option>
                                        <option value="unpaid">Un-Paid</option>
                                    </select>
                                </div>
                            </div>
                            <div></div>
                        </div>
                    </div>

                    <div id="cart-details" class="">
                        <PosCartListComponent :sessioncart="session_cart" :products="products" :currency="currency" :url="url" :csrftoken="csrftoken" @get-cart='getCart'></PosCartListComponent>
                        <div>
                            <div class="d-flex justify-content-between fw-600 mb-2 opacity-70">
                                <span>Sub Total</span>
                                <span>{{ subTotal }}</span>
                            </div>
                            <div class="d-flex justify-content-between fw-600 mb-2 opacity-70">
                                <span>Tax</span>
                                <span>{{ Tax }}</span>
                            </div>
                            <div class="d-flex justify-content-between fw-600 mb-2 opacity-70">
                                <span>Shipping</span>
                                <span>{{ Shipping }}</span>
                            </div>
                            <div class="d-flex justify-content-between fw-600 mb-2 opacity-70">
                                <span>Discount</span>
                                <span>{{ Discount}}</span>
                            </div>

                            <div v-if="advanced_payment_amount==null" class="d-flex align-items-center fw-600 mb-2 opacity-70">
                                <input id="checkbox" v-model="advanced_payment" class="text-success" type="checkbox" />
                                <label class="text-success mt-1 ml-2" for="checkbox">Add Advanced Payment</label>
                            </div>
                            <div v-else class="d-flex flex-column fw-600 mb-2 opacity-70">
                                <div class="d-flex justify-content-between">
                                    <span>Advanced</span>
                                    <span>{{ advanced_payment_amount }}</span>
                                </div>
                                <div>
                                    <input id="checkbox" v-model="advanced_payment_cancel" class="text-success" type="checkbox" @change="removeAdvanced()" />
                                    <label class="text-danger mt-1 ml-2" for="checkbox">Remove Advanced Payment</label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between fw-600 fs-18 border-top pt-2">
                                <span>Total</span>
                                <span>{{Total}}{{currency}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pos-footer mar-btm">
                <div class="d-flex flex-column flex-md-row justify-content-between">
                    <div class="d-flex">
                        <div class="dropdown mr-3 ml-0 dropup">
                            <button class="btn btn-outline-dark btn-styled dropdown-toggle" type="button" data-toggle="dropdown">
                                Shipping
                            </button>
                            <div class="dropdown-menu p-3 dropdown-menu-lg">
                                <div class="input-group">
                                    <input v-model="Shipping"  type="number" min="0" placeholder="Amount" name="shipping" class="form-control"  @change="setShipping">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Flat</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown dropup">
                            <button class="btn btn-outline-dark btn-styled dropdown-toggle" type="button" data-toggle="dropdown">
                                Discount
                            </button>
                            <div class="dropdown-menu p-3 dropdown-menu-lg">
                                <div class="input-group">
                                    <input v-model="Discount" type="number" min="0" placeholder="Amount" name="discount" class="form-control"  required @change="setDiscount">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Flat</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="my-2 my-md-0">
                        <button v-if="customer!=''" type="button" class="btn btn-primary btn-block" onclick="orderConfirmation()">Place Order</button>
                        <span v-else class="text text-danger">Select A User To Order</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Address Modal -->
        <div id="new-customer"   class="modal"  role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-dialog-zoom" role="document">
                <div class="modal-content">
                    <div class="modal-header bord-btm">
                        <h4 class="modal-title h6">Shipping Address</h4>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form id="shipping_form">
                        <div v-if="Addresses" class="">

                            <label v-for="address in Addresses" :key="address.index"   class="aiz-megabox d-block bg-white" style="display:block">
                                <input v-model="address_id"  type="radio"  name="address_id"  :value="address.id"  required>

                                <span class="d-flex p-3 pad-all aiz-megabox-elem">
                                    <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                    <span class="flex-grow-1 pl-3 pad-lft">
                                        <div>
                                            <span class="alpha-6">Address:</span>
                                            <span class="strong-600 ml-2">{{ address.address }}</span>
                                        </div>
                                        <div>
                                            <span class="alpha-6">Postal Code:</span>
                                            <span class="strong-600 ml-2">{{ address.postal_code }}</span>
                                        </div>
                                        <div>
                                            <span class="alpha-6">City:</span>
                                            <span class="strong-600 ml-2">{{ address.city }}</span>
                                        </div>
                                        <div>
                                            <span class="alpha-6">State:</span>
                                            <span class="strong-600 ml-2">{{ address.state }}</span>
                                        </div>
                                        <div>
                                            <span class="alpha-6">Country:</span>
                                            <span class="strong-600 ml-2">{{ address.country }}</span>
                                        </div>
                                        <div>
                                            <span class="alpha-6">Phone:</span>
                                            <span class="strong-600 ml-2">{{ address.phone }}</span>
                                        </div>
                                    </span>
                                </span>
                            </label>

                            <input id="customer_id" type="hidden" :value="customer.value" >
                            <div class="" onclick="add_new_address()">
                                <div class="border p-3 rounded mb-3 bord-all pad-all c-pointer text-center bg-white">
                                    <i class="fa fa-plus fa-2x"></i>
                                    <div class="alpha-7">Add New Address</div>
                                </div>
                            </div>
                        </div>

                    </form>
                    <div class="modal-footer">
                        <button   type="button" class="btn btn-styled btn-base-3" data-dismiss="modal">Close</button>
                        <button   type="button" class="btn btn-primary btn-styled btn-base-1" data-dismiss="modal" @click="setShippingAddress()">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- new address modal -->
        <div id="new-address-modal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-dialog-zoom" role="document">
                <div class="modal-content">
                    <div class="modal-header bord-btm">
                        <h4 class="modal-title h6">Add New Shipping Address</h4>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form class="form-horizontal" >

                        <div class="modal-body">
                            <input id="set_customer_id" type="hidden" name="customer_id" value="">
                            <div class="form-group">
                                <div class=" row">
                                    <label class="col-sm-2 control-label" for="address">Address</label>
                                    <div class="col-sm-10">
                                        <textarea v-model="Address" placeholder="Address" name="address" class="form-control" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class=" row">
                                    <label class="col-sm-2 control-label" for="phone">Name</label>
                                    <div class="col-sm-10">
                                        <input v-model="name" type="test" placeholder="name" name="name" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <div class=" row">
                                    <label class="col-sm-2 control-label" for="email">Country</label>
                                    <div class="col-sm-10">
                                        <select  v-model="selected_country" class="form-control " required  @change="getState()">
                                            <option value="" selected>Select One</option>
                                            <option v-for="country in countries" :key="country.index" :value="country.id">{{country.name}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div> -->
                            <div class="form-group">
                                <div class=" row">
                                    <label class="col-sm-2 control-label" for="email">City</label>
                                    <div class="col-sm-10">
                                        <select  v-model="selected_state" class="form-control " required @change="getCity()">
                                            <option value="" selected>Select One</option>
                                            <option v-for="state in states" :key="state.index" :value="state.id">{{state.name}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class=" row">
                                    <label class="col-sm-2 control-label" for="city">Upazila</label>
                                    <div class="col-sm-10">
                                        <select  v-model="selected_city" class="form-control " required >
                                            <option value="" selected>Select One</option>
                                            <option v-for="city in cities" :key="city.index" :value="city.id">{{city.name}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class=" row">
                                    <label class="col-sm-2 control-label" for="postal_code">Postal code</label>
                                    <div class="col-sm-10">
                                        <input v-model="postal_code" type="number" min="0" placeholder="Postal code" name="postal_code" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class=" row">
                                    <label class="col-sm-2 control-label" for="phone">Phone</label>
                                    <div class="col-sm-10">
                                        <input v-model="phone" type="number" min="0" placeholder="Phone" name="phone" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class=" row">
                                    <label class="col-sm-2 control-label" for="phone">Email</label>
                                    <div class="col-sm-10">
                                        <input v-model="email" type="eamil"  placeholder="email" name="email" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button ref="closeBtn1" type="button" class="btn btn-styled btn-base-3" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary btn-styled btn-base-1" @click="addNewAddress()" >Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- summary modal  -->
        <div id="order-confirm" ref="orderconfirm" class="modal fade">
            <div class="modal-dialog modal-dialog-centered modal-dialog-zoom modal-xl">
                <div id="variants" class="modal-content">
                    <div class="modal-header bord-btm">
                        <h4 class="modal-title h6">Order Summary</h4>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                    </div>
                    <div id="order-confirmation" class="modal-body">
                        <div class="p-4 text-center">
                            <i class="las la-spinner la-spin la-3x"></i>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-styled btn-base-3" data-dismiss="modal">Close</button>
                        <button type="button"  class="btn btn-styled btn-base-1 btn-primary" @click="submitOrder('cash')">Comfirm Order</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Advanced Payment Modal -->
        <div ref="advance_payment_modal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-dialog-zoom" role="document">
                <div class="modal-content">
                    <div class="modal-header bord-btm">
                        <h4 class="modal-title h6">Add Advanced Payment</h4>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form class="form-horizontal" >
                        <div class="modal-body">
                            <div class="form-group">
                                <div class=" row">
                                    <label class="col-sm-2 control-label" for="phone">Amount</label>
                                    <div class="col-sm-10">
                                        <input v-model="advanced_payment_amount" type="number" min="0" placeholder="Amount" name="advanced_payment_amount" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class=" row">
                                    <label class="col-sm-2 control-label" for="address">Note</label>
                                    <div class="col-sm-10">
                                        <textarea v-model="advanced_payment_note" placeholder="Payment Note" name="advanced_payment_note" class="form-control" required></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button ref="closeBtn" type="button" class="btn btn-styled btn-base-3" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary btn-styled btn-base-1" @click="addAdvancedPayment()" >Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import VSelect from "vue-select-picker-bootstrap";
import PosCartListComponent from './PosCartListComponent.vue';
export default {
    components: {
        VSelect,
        PosCartListComponent
    },
    props:{
        user: Object,
        categories:Array,
        brands:Array,
        url:String,
        csrftoken:String,
        currency:String,
        shipping:Number,
        discount:Number,
        customers:Array,
        countries:Array

    },
    data:()=>{
        return {
            links:[],
            products:[],
            keyword:"",
            category:"",
            brand:"",
            cats: [],
            brand_arr:[],
            customer_arr:[],
            srcable:true,
            session_cart:null,
            subTotal:0,
            Total:0,
            Tax:0,
            Discount:0,
            Shipping:0,
            customer:'',
            Addresses:null,
            Address:null,
            address_id:null,
            shipping_address:null,
            selected_country:null,
            states:[],
            selected_state:null,
            cities:[],
            selected_city:null,
            postal_code:null,
            phone:null,
            email:null,
            name:null,
            advanced_payment:false,
            advanced_payment_cancel:false,
            advanced_payment_amount:null,
            advanced_payment_note:'',
            customer_q:'',
            pay_status:'unpaid'
        };
    },
    created(){
        let arr_cat=[...this.categories];
        arr_cat.forEach((el)=>{
            this.cats.push({value:el.id,text:el.name});
        });
        let arr_brand=[...this.brands];
        arr_brand.forEach((el)=>{
            this.brand_arr.push({value:el.id,text:el.name});
        })
        this.customer_arr=[...this.customers];
        this.filterProducts();
        this.getCart();
        this.Shipping=this.shipping;
        this.Discount=this.discount;
        this.Customers=this.customers;
        this.getState()

    },

    watch:{
        customer:function(val){
            if(val && val!=''){
                this.getShippingAddress(val);
            }
        },
        advanced_payment:function(val){
            if(val){
                let el =this.$refs.advance_payment_modal;
                window.$(el).modal('show');
            }
        },
        category:function(){
            this.filterProducts();
        },
        brand:function(){
            this.filterProducts();
        }


    },
    methods:{
        filterProducts(){
            window.axios.get(`${this.url}/pos/products`,{
                params:{
                    keyword:this.keyword,
                    category:this.category.value,
                    brand:this.brand.value,
                    user_type:this.user.user_type
                }
            }).then((res)=>{
                this.links=res.data.links;
                // this.products=res.data.data.length>0?res.data.data:this.products;
                this.products=res.data.data;

            }).catch( err =>(
                console.log(err)
            ));

        },
        loadMoreProduct(){
            window.axios.get(`${this.links.next}`,{
                params:{
                    keyword:this.keyword,
                    category:this.category,
                    brand:this.brand,
                    user_type:this.user.user_type
                }
            }).then((res)=>{
                this.links=res.data.links;
                this.products=res.data.data.length>0?[ ...this.products,...res.data.data]:this.products;
            }).catch( err =>(
                console.log(err)
            ));
        },
        addToCart(id){
            window.axios.post(`${this.url}/add-to-cart-pos`,{
                _token:this.csrftoken,
                stock_id:id
            }).then((res)=>{
                this.session_cart=res.data.cart;
                this.products.forEach((el)=>{
                    if(el.stock_id==id){
                        el.stock_qty=el.stock_qty-1;
                    }
                });
                this.updateCart();

            }).catch((err)=>(console.log(err)));

        },
        getCart(){
            window.axios.get(`${this.url}/pos/get-cart`).then((res)=>{
                this.session_cart=res.data.cart;
                this.updateCart();
            }).catch((err)=>(console.log(err)));
        },
        // eslint-disable-next-line no-unused-vars
        getShippingAddress(id){
            // console.log(id);
            window.axios.post(`${this.url}/get_shipping_address`,{
                _token:this.csrftoken,
                id:this.customer
            }).then((res)=>{
                this.Addresses=res.data.addresses
                this.Addresses.forEach((el)=>{
                    if(el.default_shipping==1){
                        this.address_id=el.id;
                    }
                });
                this.$refs.addressBtn.click();

            }).catch((err)=>(console.log(err)));
        },
        setShippingAddress(){
            if(this.address_id!=null){
                window.axios.post(`${this.url}/set-shipping-address`,{
                    _token:this.csrftoken,
                    address_id:this.address_id
                }).then((res)=>{
                    this.shipping_address=res.data.address;
                }).catch((err)=>console.log(err));
            }

        },
        setDiscount(){
            window.axios.post(`${this.url}/setDiscount`,{
                _token:this.csrftoken,
                discount:this.Discount
            }).then((res)=>{
                if(res.data.success==1){
                    this.Discount=parseInt(res.data.discount)
                }
            }).catch((err)=>(console.log(err)));
        },
        setShipping(){
            window.axios.post(`${this.url}/setShipping`,{
                _token:this.csrftoken,
                shipping:this.Shipping
            }).then((res)=>{
                if(res.data.success==1){
                    this.Shipping=parseInt(res.data.shipping)
                }
            }).catch((err)=>(console.log(err)));


        },
        getState(){
            window.axios.post(`${this.url}/pos/getState`,{
                _token:this.csrftoken,
                'country_id':'1'
            }).then((res)=>{
                this.states=res.data.states
            }).catch((err)=>(console.log(err)))
        },
        getCity(){
            window.axios.post(`${this.url}/pos/getCity`,{
                _token:this.csrftoken,
                'state_id':this.selected_state
            }).then((res)=>{
                this.cities=res.data.cities
            }).catch((err)=>(console.log(err)))
        },
        addNewAddress(){
            let formData = new FormData();
            formData.append("user_id",this.customer!=''?this.customer:null );
            formData.append("address",this.Address );
            formData.append("postal_code",this.postal_code );
            formData.append("phone",this.phone );
            formData.append("email",this.email );
            formData.append("country",'1' );
            formData.append("state",this.selected_state);
            formData.append("city",this.selected_city );
            formData.append("name",this.name );

            window.axios.post(`${this.url}/pos/create-address`,formData).then((res)=>{
                if(res.data.address.default_shipping==1){
                    this.address_id=res.data.address.id;
                }
                if(res.data.user || res.data.user!=null){
                    this.customer_arr.unshift({
                        id:res.data.user.id,name:res.data.user.name,email:res.data.email
                    });
                    this.customer=res.data.user.id;

                }
                this.Addresses!=null?this.Addresses.push(res.data.address):(this.Addresses=new Array(res.data.address));

                this.$refs.closeBtn1.click();
            }).catch((err)=>(console.log(err)))
        },
        updateCart(){
            this.Tax=0;
            this.subTotal=0;
            this.Total=0;
            this.session_cart.forEach((el)=>{
                this.Tax+=el.tax;
                this.subTotal+=(el.price*parseInt(el.quantity));
            });
            this.Total+=this.Tax+this.subTotal;
        },
        submitOrder(payment_type){
            let formData = new FormData();
            formData.append("user_id",this.customer!=''?this.customer:null );
            formData.append("address",this.Address );
            formData.append("postal_code",this.postal_code );
            formData.append("phone",this.phone );
            formData.append("email",this.email );
            formData.append("country",this.selected_country );
            formData.append("state",this.selected_state);
            formData.append("city",this.selected_city );
            formData.append("shipping_address",this.address_id );
            formData.append("payment_type",payment_type );
            formData.append("shipping",this.Shipping );
            formData.append("discount",this.Discount );
            formData.append("advanced_payment_amount",this.advanced_payment_amount );
            formData.append("advanced_payment_note",this.advanced_payment_note );
            formData.append("pay_status",(this.advanced_payment?'partial':this.pay_status));
            formData.append("_token",this.csrftoken );

            window.axios.post(`${this.url}/pos-order`,formData).then((res)=>{

                if(res.data.success==1){
                    this.session_cart=null,
                    this.subTotal=0;
                    this.Total=0;
                    this.Tax=0;
                    this.Discount=0;
                    this.Shipping=0;
                    this.customer='';
                    this.pay_status='unpaid';
                    let el =this.$refs.orderconfirm;
                    window.$(el).modal('hide');


                }
            }).catch((err)=>(console.log(err)))

        //   function(data){
        //         if(data.success == 1){
        //             AIZ.plugins.notify('success', data.message );
        //             location.reload();
        //         }
        //         else{
        //             AIZ.plugins.notify('danger', data.message );
        //         }
        //     });
        },
        addAdvancedPayment(){
            let el =this.$refs.advance_payment_modal;
            window.$(el).modal('hide');
        },
        removeAdvanced(){
            this.advanced_payment=false;
            this.advanced_payment_amount=null;
            this.advanced_payment_note='';
        },
        filterCustomer(){
            window.axios.post(`${this.url}/pos/filter-customer`,{ _token:this.csrftoken,'cus_q':this.customer_q}).then((res)=>{
                this.customer_arr=res.data.customers;

            }).catch((err)=>(console.log(err)));
        }

    },
}
</script>

<style scoped>
.v-dropdown-container{
    height: 50vh!important;
    overflow-y:scroll;
}
#shipping_form{
    height: 60vh!important;
    overflow-y:scroll;
}
</style>
