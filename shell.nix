{ pkgs ? import <nixpkgs> {} }:

pkgs.mkShell {
  buildInputs = with pkgs; [
    nodejs_20
    nodePackages.npm
    nodePackages.gulp-cli
    php82
    php82Packages.composer
    wp-cli
  ];

  shellHook = ''
    echo "WordPress development environment ready!"
    echo "Available commands:"
    echo "- wp: WordPress CLI"
    echo "- gulp: Task runner"
    echo "- npm: Package manager"
    echo "- composer: PHP package manager"
  '';
} 