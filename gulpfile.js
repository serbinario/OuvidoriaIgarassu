var gulp = require('gulp');
var cleancss = require('gulp-clean-css');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');

gulp.task('default', ['js', 'css']);

var pathScripts = [
    'public/lib/jquery/dist/jquery.js',
    'public/lib/bootstrap/dist/js/bootstrap.min.js',
    'public/lib/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js',
    'public/lib/Waves/dist/waves.min.js',
    'public/lib/sweetalert2/dist/sweetalert2.min.js',
    'public/lib/datatables.net/js/jquery.dataTables.min.js',
    'public/lib/select2/dist/js/select2.full.js',
    'public/js/plugins/toastr.min.js',
    'public/js/jquery.mask.js',
    'public/js/mascaras.js',
    'public/lib/bootstrap/dist/js/bootstrap.min.js',
    'public/lib/flot/jquery.flot.js',
    'public/lib/moment/min/moment.min.js',
    'public/lib/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
    'public/lib/jquery-validation/dist/jquery.validate.js',
    'public/lib/jquery-validation/src/additional/cpfBR.js',
    'public/lib/jquery-mask-plugin/dist/jquery.mask.js',
    'public/lib/jquery-placeholder/jquery.placeholder.min.js',
    'public/lib/chosen/chosen.jquery.js',
    'public/dist/js/app.js',
    'public/js/validacoes/encaminhamento.js',
    'public/js/validacoes/reencaminhamento.js',
    'public/js/validacoes/modal_responder_ouvidor.js',
    'public/js/validacoes/modal_prorrogar_prazo_manifestacao.js',
    'public/js/demanda/detalhe_da_manifestacao.js',
    'public/js/encaminhamento/create_assunto_subassunto_ajax.js',
    'public/js/encaminhamento/encaminhamento.js',
    'public/js/validacoes/demanda.js',
    'public/js/demanda/create_demanda.js',
    'public/js/demanda/index_demanda.js',
    'public/js/plugins/highcharts.js',
    'public/js/plugins/exporting.js',
    'public/js/reports/report_comunidade.js',
    'public/js/tabelas/tabela_assuntos.js'
];

var pathStyles = [
    'public/lib/fullcalendar/dist/fullcalendar.min.css',
    'public/lib/animate.css/animate.min.css',
    'public/lib/sweetalert2/dist/sweetalert2.min.css',
    'public/lib/material-design-iconic-font/dist/css/material-design-iconic-font.min.css',
    'public/lib/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css',
    'public/lib/datatables.net-dt/css/jquery.dataTables.min.css',
    'public/lib/select2/dist/css/select2.min.css',
    'public/lib/select2-bootstrap-theme/dist/select2-bootstrap.min.cs',
    'public/lib/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css',
    'public/dist/css/validate.css',
    'public/css/plugins/toastr/toastr.min.css',
    'public/lib/chosen/chosen.css',
    'public/lib/summernote/dist/summernote.css',
    'public/dist/css/app_1.min.css',
    'public/dist/css/app_2.min.css',
    'public/dist/css/demo.css',
];

gulp.task('js', function () {
    return gulp.src(pathScripts)
        .pipe(concat('prod.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('public/dist'));
});

gulp.task('css', function () {
    return gulp.src(pathStyles)
        .pipe(concat('prod.min.css'))
        .pipe(cleancss())
        .pipe(gulp.dest('public/dist'));
});