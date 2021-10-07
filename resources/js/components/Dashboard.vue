<template>
    <div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                       <div class="card">
                            <div class="card-header">
                                Assign a task to the user
                            </div>
                            <div class="card-body">
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">User</label>
                                       <select class="form-control" v-model="userselect"  id="">
                                           <option value="0" >Select</option>
                                           <option :value="user.value" :key="idx" v-for="(user,idx) in users" >{{user.name}}</option>
                                       </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for=""> Date</label>
                                        <input type="date" v-model="date" class="form-control">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="">Task</label>
                                    <input type="text" class="form-control" v-model="task">

                                    <div class="alert alert-danger" style="margin-top:3px" v-if="error != null" role="alert">
                                          {{error}}
                                    </div>
                                    <div class="alert alert-success" style="margin-top:3px" v-if="success != null" role="alert">
                                          {{success}}
                                    </div>
                                    </div>
                                    <div class="col-md-12">
                                        
                                     <button type="button" @click="save()" class="btn btn-primary mt-1">Save</button>
                                </div>
                                </div>
                                
                               
                            </div>
                            </div>

                    </div>
                    <div class="col-md-12 ">
                        <div class="card mb-4">
                        <div class="card-header">
                          Task List
                        </div>
                            <div class="card-body">
                                <table class="table">
                                        <thead>
                                            <tr>
                                            
                                            <th scope="col">User</th>
                                            <th scope="col">Task</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Admin</th>
                                            <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr :key="idxtask" v-for="(tasks,idxtask) in tasklist">
                                                <th >{{tasks.name}}</th>
                                                <td>{{tasks.task}}</td>
                                                <td>{{tasks.date}}</td>
                                                <td>{{tasks.admin}}</td>
                                     
                                                 <td><button type="button" @click="taskdelete(tasks.taskid)" class="btn btn-danger">Del</button></td>
                                            </tr>
                                            
                                        </tbody>
                                        </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</template>
<script>
export default {
    data () {
            return {
                
                date: "",
                task:"",
                username:null,
                password:null,
                error:null,
                success:null,
                users:[],
                error:null,
                userselect:0,
                tasklist:[],
            }
        },
        async created() {
            {
                const requestOptions = {
                method: "get",
                headers: { "Content-Type": "application/json" }
            };

            const response = await fetch("/user-list", requestOptions);
            this.users = await response.json();
            
            const tasklistresponse = await fetch("/task-list", requestOptions);
             this.tasklist = await tasklistresponse.json();


            }
            
        },
         methods:{
             async save(){
                  if(this.userselect == "0")
                 {
                     this.error = "User Field cannot be left blank"
                     return false
                 }
                 if(this.date == "")
                 {
                     this.error = "Date Field cannot be left blank"
                     return false
                 }
                 if(this.task == "")
                 {
                     this.error = "Task Field cannot be left blank"
                     return false
                 }

                const postOptions = {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ task: this.task,user:this.userselect,date:this.date })
                 };
                const response = await fetch("/task-add", postOptions);
                const data = await response.json();
                if(data.status == false)
                {
                    this.error = data.message;

                    return false;
                }
                else
                {
                this.tasklist = data;
                this.success = "Created Succesfull";
                this.date = "";
                this.task = "";
                this.userselect = 0;
                }
               
             },
             async taskdelete(valid)
             {
                 console.log(valid);
                  const requestOptions = {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ id: valid })
                };

                 const tasklistresponse = await fetch("/taskdeletes", requestOptions);
                 this.tasklist = await tasklistresponse.json();


             }
         }
        
}
</script>