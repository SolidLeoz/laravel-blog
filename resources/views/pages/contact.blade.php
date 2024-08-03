@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Contact Me</h1>
    
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Get in Touch</h5>
            <p class="card-text">
                Have a question or just want to say hello? Feel free to reach out to me using the information below:
            </p>
            <ul class="list-unstyled">
                <li>Email: <a href="mailto:your.email@example.com">your.email@example.com</a></li>
                <li>Twitter: <a href="https://twitter.com/yourusername" target="_blank">@yourusername</a></li>
                <li>LinkedIn: <a href="https://www.linkedin.com/in/yourprofile" target="_blank">Your Name</a></li>
            </ul>
            <p class="card-text">
                I'll do my best to respond to your message as soon as possible. Thanks for your interest!
            </p>
        </div>
    </div>
</div>
@endsection