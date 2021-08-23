
import Dashboard from './components/UserList';
import Todo from './components/TodoList';
import NotFound from './components/NotFound';

  export default {
    mode:'history',
    routes: [
        {
         path: '/',
         component: Dashboard,
         name: 'Admin',
         beforeEnter: (to, form, next) =>{
          axios.get('/user-role').then((user)=>{
            console.log(user);
              if(user.data.role == 'user'){
                return next({ name: 'Todo'})
              }else{
                return next()
              }
          }).catch(()=>{
              return next({ name: 'Todo'})
          })
      }
         
        },
        {
         path: '/todo-list',
         component: Todo,
         name: 'Todo',
        },
        {
            path: '*',
            component: NotFound
        }
      ],
  };

