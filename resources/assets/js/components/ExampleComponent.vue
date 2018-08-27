<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">fsdfsdfsdfsExample Component1вв!!!!!!!!!!!!!</div>

                    <div class="card-body">

                      jjjjjjjjjjjjjjjjjj  11111I'm an example component.111
                        {{ testdata.val}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
	export default {
		props: [
			'testdata'
		],
		mounted() {
			console.log('Component mounted 22.');
            this.logdata();
		},
        methods: {
			logdata: function () {
                console.log(this.testdata);
			}
        }
	}
</script>
