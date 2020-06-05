<template>
	<div>
		
    <ul>
      <li v-for="tasks in project.tasks" v-text='tasks.body'></li>
    </ul>

    <input type="text" @keypress.enter="save()" v-model="newTask">
	</div>
</template>

<script>
export default {

  name: 'TaskList',
  props: { dataproject: { type: Object, required: true } },
  data() {
    return {
    	project: this.dataproject,
    	newTask:''
    };
  },
  created(){
    Echo.channel('tasks.'+this.project.id)
    .listen('TaskCreated', (e) => {
        //console.log(e);
        this.addTask(e.task)
    });
  },
  methods:{
  	save(){
  		axios.post(`/api/projects/${this.project.id}/tasks`, {body: this.newTask})
  			.then(response=>response.data)
  			.then(this.addTask);
  	},
  	addTask(task){
  		this.project.tasks.push(task)
  		this.newTask='';
  	}
  }
};
</script>

<style lang="css" scoped>
</style>
