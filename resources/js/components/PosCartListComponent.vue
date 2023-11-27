<template>
    <div class="aiz-pos-cart-list mb-4 mt-3 ">

        <ul v-if="sessioncart!=null" class="list-group list-group-flush">
            <li v-for="cart in carts" :key="cart.index"  class="list-group-item py-0 pl-2">
                <div  class="row gutters-5 align-items-center">

                    <div class="col-auto w-60px">
                        <div class="row no-gutters align-items-center flex-column">
                            <button class="btn col-auto btn-icon btn-sm fs-15" type="button" data-type='plus' @click="updateQty(cart.key,$event)" >
                                <i class="las la-plus"></i>
                            </button>
                            <input :ref="'inp'+cart.key" type="text" name="" class="col border-0 text-center flex-grow-1 fs-16 input-number" placeholder="1"  :value="cart.quantity"   @change="updateQuantity(cart.key)">
                            <button class="btn col-auto btn-icon btn-sm fs-15" type="button" @click="updateQty(cart.key,$event)" >
                                <i class="las la-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col">
                        <div class="text-truncate-2">{{ cart.name }}</div>
                        <span class="span badge badge-inline fs-12 badge-soft-secondary">{{ cart.variant_name }}</span>
                    </div>
                    <div class="col-auto">
                        <div class="fs-12 opacity-60">{{ cart.quantity }} x {{ cart.price }}</div>
                        <div class="fs-15 fw-600">{{ (parseInt(cart.quantity) * cart.price)  }}{{currency}}</div>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-circle btn-icon btn-sm btn-soft-danger ml-2 mr-0" @click="removeFromCart(cart.key)">
                            <i class="las la-trash-alt"></i>
                        </button>
                    </div>
                </div>
            </li>
        </ul>
        <ul v-else>
            <li  class="list-group-item">
                <div class="text-center">
                    <i class="las la-frown la-3x opacity-50"></i>
                    <p>No Product Added</p>
                </div>
            </li>
        </ul>

    </div>
</template>

<script>
export default {
    props:{
        sessioncart:{
            type:Array,
            default:null

        },
        products:Array,
        currency:String,
        url:String,
        csrftoken:String
    },
    data:()=>{
        return {
            qty:0
        };
    },
    created(){

    },
    computed:{
        carts:function(){
            let res=[];
            let ids=[];
            if(this.sessioncart  && this.sessioncart.length>0){
                this.sessioncart.forEach(elem => {
                    ids.push(elem.stock_id);
                });
                let f_products=this.products.filter((el)=>{
                    if(ids.includes(el.stock_id)){
                        return el;
                    };
                });
                res=this.sessioncart.map((el,key)=>{
                    let product=f_products.filter((p)=>{
                        if(p.stock_id==el.stock_id){
                            return p;
                        }
                    });
                    return {...el,...product[0],"key":key};
                });


            }
            return res;
        }
    },
    methods:{
        removeFromCart(key){
            window.axios.post(`${this.url}/remove-from-cart-pos`,{_token:this.csrftoken, key:key}).then((res)=>{
                if(res.data.success==1){
                    this.$emit('get-cart',key);
                }
            }).catch((err)=>(console.log(err)));
        },
        updateQuantity(key,quantity){
            window.axios.post(`${this.url}/update-quantity-cart-pos`,   {_token:this.csrftoken, key:key, quantity:quantity }).
                then((res)=>{
                    if(res.data.success==1){
                        this.$emit('get-cart',key);
                    }
                }).catch((err)=>(console.log(err)))

        },
        updateQty(key,event){
            let re='inp'+key;
            let tmp=this.$refs[`${re}`][0].value;
            this.carts.map((el)=>{
                if(el.key==key){
                    if(event.target.classList[1]=='la-plus'){
                        this.$refs[`${re}`][0].value=parseInt(tmp)+1<=el.stock_qty?parseInt(tmp)+1:parseInt(tmp);
                        this.updateQuantity(key, this.$refs[`${re}`][0].value);

                    }else{
                        this.$refs[`${re}`][0].value=parseInt(tmp)-1>=1?parseInt(tmp)-1:parseInt(tmp);
                        this.updateQuantity(key, this.$refs[`${re}`][0].value);
                    }
                }
            });
        },


    }


}
</script>

<style>

</style>
