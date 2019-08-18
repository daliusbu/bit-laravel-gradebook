<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script>
CKEDITOR.replace( 'ck-editor-field', {
    customConfig: '{{ asset('vendor/unisharp/laravel-ckeditor/config.js') }}',
	language: '{{ app()->getLocale() }}',
	htmlEncodeOutput: false,
	allowedContent: true,
	basicEntities: false,
	entities: true
});
</script>