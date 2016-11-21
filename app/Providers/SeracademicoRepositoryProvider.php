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
            \Seracademico\Repositories\EnderecoRepository::class,
            \Seracademico\Repositories\EnderecoRepositoryEloquent::class
        );


        $this->app->bind(
            \Seracademico\Repositories\EstadoRepository::class,
            \Seracademico\Repositories\EstadoRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\SexoRepository::class,
            \Seracademico\Repositories\SexoRepositoryEloquent::class
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
        
		$this->app->bind(
			\Seracademico\Repositories\Ouvidoria\AssuntoRepository::class,
			\Seracademico\Repositories\Ouvidoria\AssuntoRepositoryEloquent::class
		);
        

		$this->app->bind(
			\Seracademico\Repositories\Ouvidoria\SubassuntoRepository::class,
			\Seracademico\Repositories\Ouvidoria\SubassuntoRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\Ouvidoria\MelhoriaRepository::class,
			\Seracademico\Repositories\Ouvidoria\MelhoriaRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\Ouvidoria\EncaminhamentoRepository::class,
			\Seracademico\Repositories\Ouvidoria\EncaminhamentoRepositoryEloquent::class
		);
	}
}