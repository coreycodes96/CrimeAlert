<template>
     <!-- Terms and conditions modal -->
    <div class="termsAndConditions ml-min-100 fixed top-0 left-0 w-full h-screen bg-indigo-800">

        <!-- Close terms and conditions button -->
        <div class="absolute top-5 right-5 text-white">
            <i class="fas fa-times text-2xl cursor-pointer" @click="closeTermsAndConditions"></i>
        </div>

        <!-- Terms and conditions container -->
        <div class="mt-40 mx-auto p-3 w-4/5 sm:h-auto h-96 sm:overflow-hidden overflow-y-scroll bg-white rounded">
            <p class="mb-2">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                Voluptates non quos earum quis ullam 
                facere quisquam explicabo ab? Dolorum minus esse at, 
                temporibus incidunt nesciunt minima veniam quod nobis ad?
            </p>
            <p class="my-2">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                Voluptates non quos earum quis ullam 
                facere quisquam explicabo ab? Dolorum minus esse at, 
                temporibus incidunt nesciunt minima veniam quod nobis ad?
            </p>
            <p class="my-2">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                Voluptates non quos earum quis ullam 
                facere quisquam explicabo ab? Dolorum minus esse at, 
                temporibus incidunt nesciunt minima veniam quod nobis ad?
            </p>
            <p class="my-2">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                Voluptates non quos earum quis ullam 
                facere quisquam explicabo ab? Dolorum minus esse at, 
                temporibus incidunt nesciunt minima veniam quod nobis ad?
                facere quisquam explicabo ab? Dolorum minus esse at, 
                temporibus incidunt nesciunt minima veniam quod nobis ad?
            </p>
        </div>
    </div>
</template>

<script>
export default {
    methods:{
        //Close terms and conditions
        closeTermsAndConditions(){
            tl.to('.termsAndConditions', {marginLeft: '-100%', duration: 0.3, ease: "power3.out"});
        }
    }
}
</script>