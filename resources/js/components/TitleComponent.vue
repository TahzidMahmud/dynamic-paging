<template>
    <div class="row">
        <div class="col-12">
            <label>Enter Article Title</label>
            <input class="form-control" v-model="title" value="" @change="handleChange" placeholder="Please Enter Article Title Here..."/>
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
            title:''
        }
    },
    methods:{
        handleChange(){
            this.$emit('handleChange',{attr_key:this.key,value:this.title});
        }
    }
}
</script>

<style>

</style>
