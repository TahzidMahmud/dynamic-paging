<template>
  <div>
    <div class="card" style="width: 18rem;">
    <div class="card-body">
        <h5 class="card-title" v-if="title!=''">{{ title }}</h5>
        <h6 class="card-subtitle mb-2 text-muted"  v-if="sub_title!=''">{{ sub_title }}</h6>
        <p class="card-text" v-if="list.length>0">
            <ul>
                <li v-for="(item, index) in list" :key="index">
                    {{ item }}
                </li>
            </ul>
        </p>

    </div>
    </div>
  </div>
</template>

<script>
export default {
    props:{
        values:{
            type:Array
        }
    },
    data:()=>{
        return {
          items:[],
          title:'',
          sub_title:'',
          list:[],
        };
    },
    created(){
        this.items=this.values.sort((a, b) => a.order - b.order);
        this.items.map((item)=>{
            if(item.key=='title'){
                this.title=item.value;
            }else if(item.key=='sub_title'){
                this.sub_title=item.value;
            }else if(item.key=='list'){
                this.list=item.value;
            }
        })
    },
}
</script>

<style>

</style>
