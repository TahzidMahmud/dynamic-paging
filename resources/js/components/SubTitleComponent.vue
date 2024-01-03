<template>
    <div class="row">
        <div class="col-12">
            <label>Enter Article Sub-Title</label>
            <input class="form-control" v-model="sub_title" value="" @change="handleChange" placeholder="Please Enter Article sub-Title Here..."/>
        </div>
    </div>
</template>

<script>
export default {
    props:{
        attr_key:{
            type:String,
        },
    },
    data:()=>{
        return {
            sub_title:'',
        }
    },
    methods:{
        handleChange(){
            this.$emit('handleChange',{"attr_key":this.attr_key,value:this.sub_title});
        }
    }
}
</script>

<style>

</style>
