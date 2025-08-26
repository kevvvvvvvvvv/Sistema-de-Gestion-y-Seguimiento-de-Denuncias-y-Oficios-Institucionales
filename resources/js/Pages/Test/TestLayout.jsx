import MainLayout from '@/Layouts/MainLayout';

export default function Test({ auth }) {
  return <div>Editar perfil</div>;
}

Test.layout = (page) => <MainLayout auth={page.props.auth}>{page}</MainLayout>;

