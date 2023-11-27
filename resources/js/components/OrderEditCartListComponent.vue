<template>
    <div class="aiz-pos-cart-list mb-4 mt-3 ">

        <ul v-if="carts!=null" class="list-group list-group-flush">
            <li v-for="cart in carts" :key="cart.index"  class="list-group-item py-0 pl-2">
                <div  class="row gutters-5 align-items-center">

                    <div class="col-auto w-60px">
                        <div class="row no-gutters align-items-center flex-column">
                            <button class="btn col-auto btn-icon btn-sm fs-15" type="button" data-type='plus' @click="updateQty(cart.product_variation_id,$event)" >
                                <i class="las la-plus"></i>
                            </button>
                            <input :ref="'inp'+cart.product_variation_id" type="text" name="" class="col border-0 text-center flex-grow-1 fs-16 input-number" placeholder="1"  :value="cart.quantity"   @change="updateQuantity(cart.product_variation_id)">
                            <button class="btn col-auto btn-icon btn-sm fs-15" type="button" @click="updateQty(cart.product_variation_id,$event)" >
                                <i class="las la-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col">
                        <div class="text-truncate-2">{{ cart.name }}</div>
                        <span class="span badge badge-inline fs-12 badge-soft-secondary">{{ cart.code }}</span>
                    </div>
                    <div class="col-auto">
                        <div class="fs-12 opacity-60">{{ cart.quantity }} x {{ cart.price }}</div>
                        <div class="fs-15 fw-600">{{ (parseInt(cart.quantity) * cart.price)  }}{{currency}}</div>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-circle btn-icon btn-sm btn-soft-danger ml-2 mr-0" @click="removeFromCart(cart.product_variation_id)">
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
        carts:{
            type:Array,
            default:null

        },
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

    },
    methods:{
        removeFromCart(key){
            console.log(key);
            this.$emit('update-cart',{key:key,operation:'remove'});
        },

        updateQty(key,event){
            let re='inp'+key;
            let tmp=this.$refs[`${re}`][0].value;
            this.carts.map((el)=>{
                if(el.product_variation_id==key){
                    if(event.target.classList[1]=='la-plus'){
                        if(parseInt(tmp)+1<=el.stock){
                            this.$refs[`${re}`][0].value=parseInt(tmp)+1;
                            this.$emit('update-cart',{key:key,quantity:parseInt(tmp)+1,operation:'plus'});
                        }
                    }else{
                        console.log('hit');
                        if(parseInt(tmp)-1>0){
                            this.$refs[`${re}`][0].value=parseInt(tmp)-1;
                            this.$emit('update-cart',{key:key,quantity:parseInt(tmp)-1,operation:'minus'});
                        }
                    }
                }
            });
        },


    }


}
</script>

<style>

</style>
