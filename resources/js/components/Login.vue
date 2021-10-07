<template>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center align-items-center mt-3">
                    <div class="card">
                    <h5 class="card-header">Login</h5>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" v-model="username">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="password">Password</label>
                                        <input type="password"  class="form-control" v-model="password">
                                    </div>
                                   
                                     <div class="alert alert-danger" style="margin-top:3px" v-if="this.error != null" role="alert">
                                        {{error}}
                                        </div>
                                         <div class="alert alert-success" style="margin-top:3px" v-if="this.success != null" role="alert">
                                        {{success}}
                                        </div>
                                    <div class="col-md-12">
                                        <button type="button" @click="Login()" class="btn btn-success mt-3">Login</button>
                                    </div>


                                   
                                </div>
                                
                                

                                
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
                info: null,
                username:null,
                password:null,
                error:null,
                success:null
            }
        },
            methods:{
          async  Login(){
              this.error = null;
            const requestOptions = {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ username: this.username,password:this.password })
            };
                const response = await fetch("/login-control", requestOptions);
                const data = await response.json();
                if(data.status == false)
                {
                      this.error = data.error;
                }
                else
                {
                    this.success = data.message;
                  window.location.href = "/dashborad"
                }
            },
           
        }
    }
</script>
