set :application, "DDD Example"
set :domain,      "my_project.com"
set :user,        "alsar"
set :deploy_to,   "/home/alsar/www/ddd-example.si"

set :repository,  "git@github.com:alsar/ddd-example.git"
set :scm,         :git

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain, :primary => true       # This may be the same as your `Web` server
role :db,         domain, :primary => true

set :use_sudo,      false
set :keep_releases,  3

set :deploy_via, :remote_cache
#set :deploy_via, :capifony_copy_local

set :shared_files,      ["app/config/parameters.yml"]
set :shared_children,   ["var/log", "var/session", "vendor"]
set :use_composer,      true

set :writable_dirs,       ["var", "var/log", "var/session"]
set :webserver_user,      "www-data"
set :permission_method,   :acl
set :use_set_permissions, true

#logger.level = Logger::MAX_LEVEL
