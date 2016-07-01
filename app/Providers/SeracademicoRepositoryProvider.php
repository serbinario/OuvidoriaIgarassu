<?php

namespace Seracademico\Providers;

use Illuminate\Support\ServiceProvider;

class SeracademicoRepositoryProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind(
            \Seracademico\Repositories\BairroRepository::class,
            \Seracademico\Repositories\BairroRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\CidadeRepository::class,
            \Seracademico\Repositories\CidadeRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\CorRacaRepository::class,
            \Seracademico\Repositories\CorRacaRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\EnderecoRepository::class,
            \Seracademico\Repositories\EnderecoRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\EstadoCivilRepository::class,
            \Seracademico\Repositories\EstadoCivilRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\EstadoRepository::class,
            \Seracademico\Repositories\EstadoRepositoryEloquent::class
        );
        
        $this->app->bind(
            \Seracademico\Repositories\ReligiaoRepository::class,
            \Seracademico\Repositories\ReligiaoRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\SexoRepository::class,
            \Seracademico\Repositories\SexoRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\TipoSanguinioRepository::class,
            \Seracademico\Repositories\TipoSanguinioRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\TipoSanguinioRepository::class,
            \Seracademico\Repositories\TipoSanguinioRepositoryEloquent::class
        );
        
        $this->app->bind(
            \Seracademico\Repositories\UserRepository::class,
            \Seracademico\Repositories\UserRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\RoleRepository::class,
            \Seracademico\Repositories\RoleRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\PermissionRepository::class,
            \Seracademico\Repositories\PermissionRepositoryEloquent::class
        );
        
        $this->app->bind(
            \Seracademico\Repositories\Biblioteca\EditoraRepository::class,
            \Seracademico\Repositories\Biblioteca\EditoraRepositoryEloquent::class
        );
        $this->app->bind(
            \Seracademico\Repositories\Biblioteca\ArcevoRepository::class,
            \Seracademico\Repositories\Biblioteca\ArcevoRepositoryEloquent::class
        );
        $this->app->bind(
            \Seracademico\Repositories\Biblioteca\TipoAcervoRepository::class,
            \Seracademico\Repositories\Biblioteca\TipoAcervoRepositoryEloquent::class
        );
        $this->app->bind(
            \Seracademico\Repositories\Biblioteca\TipoAutorRepository::class,
            \Seracademico\Repositories\Biblioteca\TipoAutorRepositoryEloquent::class
        );
        $this->app->bind(
            \Seracademico\Repositories\Biblioteca\SegundaEntradaRepository::class,
            \Seracademico\Repositories\Biblioteca\SegundaEntradaRepositoryEloquent::class
        );
        $this->app->bind(
            \Seracademico\Repositories\Biblioteca\PrimeiraEntradaRepository::class,
            \Seracademico\Repositories\Biblioteca\PrimeiraEntradaRepositoryEloquent::class
        );
        $this->app->bind(
            \Seracademico\Repositories\Biblioteca\ColecaoRepository::class,
            \Seracademico\Repositories\Biblioteca\ColecaoRepositoryEloquent::class
        );
        $this->app->bind(
            \Seracademico\Repositories\Biblioteca\GeneroRepository::class,
            \Seracademico\Repositories\Biblioteca\GeneroRepositoryEloquent::class
        );
        $this->app->bind(
            \Seracademico\Repositories\Biblioteca\CorredorRepository::class,
            \Seracademico\Repositories\Biblioteca\CorredorRepositoryEloquent::class
        );
        $this->app->bind(
            \Seracademico\Repositories\Biblioteca\EstanteRepository::class,
            \Seracademico\Repositories\Biblioteca\EstanteRepositoryEloquent::class
        );
        $this->app->bind(
            \Seracademico\Repositories\Biblioteca\SituacaoRepository::class,
            \Seracademico\Repositories\Biblioteca\SituacaoRepositoryEloquent::class
        );
        $this->app->bind(
            \Seracademico\Repositories\Biblioteca\IdiomaRepository::class,
            \Seracademico\Repositories\Biblioteca\IdiomaRepositoryEloquent::class
        );
        $this->app->bind(
            \Seracademico\Repositories\Biblioteca\AquisicaoRepository::class,
            \Seracademico\Repositories\Biblioteca\AquisicaoRepositoryEloquent::class
        );
        $this->app->bind(
            \Seracademico\Repositories\Biblioteca\IlustracaoRepository::class,
            \Seracademico\Repositories\Biblioteca\IlustracaoRepositoryEloquent::class
        );
        $this->app->bind(
            \Seracademico\Repositories\Biblioteca\EmprestimoRepository::class,
            \Seracademico\Repositories\Biblioteca\EmprestimoRepositoryEloquent::class
        );
        $this->app->bind(
            \Seracademico\Repositories\Biblioteca\ExemplarRepository::class,
            \Seracademico\Repositories\Biblioteca\ExemplarRepositoryEloquent::class
        );
        $this->app->bind(
            \Seracademico\Repositories\Biblioteca\ResponsavelRepository::class,
            \Seracademico\Repositories\Biblioteca\ResponsavelRepositoryEloquent::class
        );
        
		$this->app->bind(
			\Seracademico\Repositories\Biblioteca\EmprestarRepository::class,
			\Seracademico\Repositories\Biblioteca\EmprestarRepositoryEloquent::class
		);
		$this->app->bind(
			\Seracademico\Repositories\Biblioteca\EmprestimoExemplarRepository::class,
			\Seracademico\Repositories\Biblioteca\EmprestimoExemplarRepositoryEloquent::class
		);
		$this->app->bind(
			\Seracademico\Repositories\Biblioteca\ReservaRepository::class,
			\Seracademico\Repositories\Biblioteca\ReservaRepositoryEloquent::class
		);
		$this->app->bind(
			\Seracademico\Repositories\Biblioteca\ReservaExemplarRepository::class,
			\Seracademico\Repositories\Biblioteca\ReservaExemplarRepositoryEloquent::class
		);

        $this->app->bind(
            \Seracademico\Repositories\Biblioteca\PessoaRepository::class,
            \Seracademico\Repositories\Biblioteca\PessoaRepositoryEloquent::class
        );

		$this->app->bind(
			\Seracademico\Repositories\ParametroRepository::class,
			\Seracademico\Repositories\ParametroRepositoryEloquent::class
		);

        $this->app->bind(
            \Seracademico\Repositories\ItemParametroRepository::class,
            \Seracademico\Repositories\ItemParametroRepositoryEloquent::class
        );
        
		$this->app->bind(
			\Seracademico\Repositories\Ouvidoria\DemandaRepository::class,
			\Seracademico\Repositories\Ouvidoria\DemandaRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\Ouvidoria\AreaRepository::class,
			\Seracademico\Repositories\Ouvidoria\AreaRepositoryEloquent::class
		);
		$this->app->bind(
			\Seracademico\Repositories\Ouvidoria\SigiloRepository::class,
			\Seracademico\Repositories\Ouvidoria\SigiloRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\Ouvidoria\AnonimoRepository::class,
			\Seracademico\Repositories\Ouvidoria\AnonimoRepositoryEloquent::class
		);
		$this->app->bind(
			\Seracademico\Repositories\Ouvidoria\IdadeRepository::class,
			\Seracademico\Repositories\Ouvidoria\IdadeRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\Ouvidoria\ExclusividadeSUSRepository::class,
			\Seracademico\Repositories\Ouvidoria\ExclusividadeSUSRepositoryEloquent::class
		);
		$this->app->bind(
			\Seracademico\Repositories\Ouvidoria\InformacaoRepository::class,
			\Seracademico\Repositories\Ouvidoria\InformacaoRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\Ouvidoria\EscolaridadeRepository::class,
			\Seracademico\Repositories\Ouvidoria\EscolaridadeRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\Ouvidoria\TipoDemandaRepository::class,
			\Seracademico\Repositories\Ouvidoria\TipoDemandaRepositoryEloquent::class
		);
        
	}
}