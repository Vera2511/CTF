-- TABLE CREATION SECTION

CREATE TABLE public.login_data (
    team_id integer NOT NULL,
    login character varying(50) NOT NULL,
    pass text NOT NULL
);

CREATE TABLE public.tasks (
    task_id integer NOT NULL,
    task_name character varying(50) NOT NULL,
    descr text,
    answer text,
    is_file boolean,
    filename text
);

CREATE TABLE public.teams (
    team_id integer NOT NULL,
    team_name character varying(50) NOT NULL,
    team_size integer NOT NULL,
    score integer,
    on_route boolean,
    reg_date date,
    current_task integer
);

ALTER TABLE ONLY public.login_data
    ADD CONSTRAINT login_data_pkey PRIMARY KEY (team_id);

ALTER TABLE ONLY public.tasks
    ADD CONSTRAINT tasks_pkey PRIMARY KEY (task_id);

ALTER TABLE ONLY public.teams
    ADD CONSTRAINT teams_pkey PRIMARY KEY (team_id);

ALTER TABLE ONLY public.teams
    ADD CONSTRAINT current_task FOREIGN KEY (current_task) REFERENCES public.tasks(task_id) NOT VALID;

ALTER TABLE ONLY public.login_data
    ADD CONSTRAINT team_login FOREIGN KEY (team_id) REFERENCES public.teams(team_id) NOT VALID;

-- FUNCTION AND TRIGGER CREATION SECTION

CREATE FUNCTION public.encrypt_password() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
new.pass = md5(new.pass);
RETURN NEW;
END;
$$;

CREATE TRIGGER pass_encryption BEFORE INSERT OR UPDATE OF pass ON public.login_data FOR EACH ROW EXECUTE FUNCTION public.encrypt_password();

CREATE FUNCTION public.top_score(people_count integer) RETURNS TABLE(team character varying, score integer)
    LANGUAGE plpgsql
    AS $$
BEGIN
RETURN QUERY SELECT teams.team_name, teams.score FROM teams
WHERE teams.team_size = people_count ORDER BY teams.score DESC;
END;
$$;

-- INSERT SECTION

INSERT INTO public.tasks (task_id, task_name, descr, answer, is_file, filename) VALUES (2, 'DotDot', 'Студент, нашел на компьютере в университете, на рабочем столе странный файл. Что же в нем? Может быть можно что-то найти в интернете?', '11cd7c080f299d7839c650d9bf4e2c7c', true, '1');
INSERT INTO public.tasks (task_id, task_name, descr, answer, is_file, filename) VALUES (3, 'Japanese grid', 'На нашу корпоративную почту пришло письмо с весьма странным архивом. Сможешь разобраться в чем дело?
', 'CTF{0k_u_HaVE_D0nE_1t}', true, 'j.rar');
INSERT INTO public.tasks (task_id, task_name, descr, answer, is_file, filename) VALUES (4, 'Reverse !', 'Вы нашли файл со странными бинарными данными, что же это может быть ?
', 'CTF{0f4d0db3668dd58cabb9eb409657eaa8}', true, 'binary.txt');
INSERT INTO public.tasks (task_id, task_name, descr, answer, is_file, filename) VALUES (5, 'Салат Цезарь', 'Должно быть лучший салат в мире. А вы можете расшифровать это для нас?

xyzqc{t3_qelrdeq_t3_k33a3a_lk3_lc_qe3p3}', 'abctf{w3_thought_w3_n33d3d_on3_of_th3s3}', false, NULL);
INSERT INTO public.tasks (task_id, task_name, descr, answer, is_file, filename) VALUES (1, 'Неправильная криптография', 'Данное задание относится к категории Crypto. По легенде, был перехвачен сеанс связи, и командам нужно расшифровать переданные сообщения.', 'its_n0t_ab0ut_p4dd1ng', true, 'задание 1.txt');

INSERT INTO public.teams (team_id, team_name, team_size, score, on_route, reg_date, current_task) VALUES (4, 'decrypters', 5, 0, false, '2021-11-11', NULL);
INSERT INTO public.teams (team_id, team_name, team_size, score, on_route, reg_date, current_task) VALUES (5, 'qword', 5, 0, false, '2021-11-12', NULL);
INSERT INTO public.teams (team_id, team_name, team_size, score, on_route, reg_date, current_task) VALUES (6, 's3quence', 5, 0, false, '2021-11-13', NULL);
INSERT INTO public.teams (team_id, team_name, team_size, score, on_route, reg_date, current_task) VALUES (7, 'redcode', 7, 0, false, '2021-11-15', NULL);
INSERT INTO public.teams (team_id, team_name, team_size, score, on_route, reg_date, current_task) VALUES (8, 'watershell', 7, 0, false, '2021-11-18', NULL);
INSERT INTO public.teams (team_id, team_name, team_size, score, on_route, reg_date, current_task) VALUES (9, 'h4ckers', 7, 0, false, '2021-11-19', NULL);
INSERT INTO public.teams (team_id, team_name, team_size, score, on_route, reg_date, current_task) VALUES (1, 'zer0points', 3, 0, false, '2021-11-04', NULL);
INSERT INTO public.teams (team_id, team_name, team_size, score, on_route, reg_date, current_task) VALUES (2, 'flagbots', 3, 0, false, '2021-11-04', NULL);
INSERT INTO public.teams (team_id, team_name, team_size, score, on_route, reg_date, current_task) VALUES (3, 'over9000', 3, 0, false, '2021-11-05', NULL);

INSERT INTO public.login_data (team_id, login, pass) VALUES (1, 'zer0', 'zer01');
INSERT INTO public.login_data (team_id, login, pass) VALUES (2, 'flagbot', 'flagbot2');
INSERT INTO public.login_data (team_id, login, pass) VALUES (3, 'overs', 'overs3');
INSERT INTO public.login_data (team_id, login, pass) VALUES (4, 'crypter', 'crypter4');
INSERT INTO public.login_data (team_id, login, pass) VALUES (5, 'queword', 'queword5');
INSERT INTO public.login_data (team_id, login, pass) VALUES (6, 'seqnce', 'seqnce6');
INSERT INTO public.login_data (team_id, login, pass) VALUES (7, 'redcoder', 'redcoder7');
INSERT INTO public.login_data (team_id, login, pass) VALUES (8, 'wshell', 'wshell8');
INSERT INTO public.login_data (team_id, login, pass) VALUES (9, 'hackerman', 'hackerman9');