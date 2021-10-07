<template>
    <div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                       <div class="card">
                            <div class="card-header">
                                Created User
                            </div>
                            <div class="card-body">
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Name</label>
                                      <input type="text" class="form-control" v-model="name">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Username</label>
                                      <input type="text" class="form-control" v-model="username">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Email</label>
                                      <input type="text" class="form-control" v-model="email">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Password</label>
                                      <input type="password" class="form-control" v-model="password">
                                    </div>
                                    <div class="col-md-12" >
                                        <select v-model="role" id="" class="form-control" style="margin-top:4px">
                                            <option value="">Selected</option>
                                            <option value="0">User</option>
                                            <option value="1">Admin</option>
                                        </select>
                                    </div>
                                    

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
                                            
                                            <th scope="col">Name</th>
                                            <th scope="col">Username</th>
                                            <th scope="col">E-mail</th>
                                            <th scope="col">Role</th>
                                            <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr :key="idx" v-for="(user,idx) in users">
                                                <th >{{user.name}}</th>
                                                <td>{{user.username}}</td>
                                                <td>{{user.email}}</td>
                                                <td>
                                                    <span v-if="user.role == 1">Admin</span>
                                                    <span v-if="user.role == 0">User</span>
                                                  
                                                    
                                                </td>
                                     
                                                 <td><button type="button" @click="userdelete(user.value)" class="btn btn-danger">Del</button></td>
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
                error:null,
                success:null,
                name:"",
                username:"",
                password:"",
                email:"",
                users:[],
                role:"",
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


            }
            
        },
        methods:{
            async save(){
                  if(this.name == null)
                 {
                     this.error = "Name Field cannot be left blank"
                     return false
                 }
                 if(this.username == "")
                 {
                     this.error = "Username Field cannot be left blank"
                     return false
                 }
                  if(this.email == "")
                 {
                     this.error = "Email Field cannot be left blank"
                     return false
                 }
                   if(this.role == "")
                 {
                     this.error = "Role Field cannot be left blank"
                     return false
                 }
                 if(this.password == "")
                 {
                     this.error = "Task Field cannot be left blank"
                     return false
                 }

                 const postOptions = {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ 
                        name: this.name,
                        username:this.username,
                        email:this.email,
                        role:this.role,
                        password:this.password,
                         })
                 };
                const response = await fetch("/user-add", postOptions);
                const data = await response.json();
                if(data.status == false)
                {
                    this.error = data.message;
                   return false;
                }
                else
                {
                this.users = data;
                this.success = "Created Succesfull";
                this.name = "";
                this.username = "";
                this.error = null;
                 this.email = "";
                 this.pasasword = "";
                }
            },
             async userdelete(val){
                     const postOptions = {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ 
                        id: val
                    })
                 };
                const response = await fetch("/user-delete", postOptions);
                const data = await response.json();
                if(data.status == false)
                {
                    this.error = data.message;
                   return false;
                }
                else
                {
                this.users = data;
                this.success = "Deleted Succesfull";
                this.name = "";
                this.username = "";
                this.error = null;
                 this.email = "";
                 this.pasasword = "";
                }

             }
        }
        
}
</script>